<script lang="ts">
	// svelte tools
	import { onMount } from 'svelte';

	// icons
	import Icon from '@iconify/svelte';

	// import milik sendiri
	import Navbar from '$lib/components/Navbar.svelte';
	import { notifError, notifSuccess } from '$lib/scripts/notif';
	import api from '$lib/axiosConfig';
	import { base64ToObjectURL } from '$lib/scripts/objectURLConverter';

	// type
	interface DomisiliStore {
		provinsi: Array<{ id: number; nama_provinsi: string }>;
		kabupaten: Array<{ id: number; nama_kabupaten: string; provinsi_id: number }>;
		kecamatan: Array<{ id: number; nama_kecamatan: string; kabupaten_id: number }>;
		kelurahan: Array<{ id: number; nama_kelurahan: string; kecamatan_id: number }>;
	}

	interface Profile {
		sekolah: string;
		provinsi: number;
		kabupaten: number;
		kecamatan: number;
		kelurahan: number;
		photo: string;
	}

	interface ProfileResponse {
		school: string;
		nama_provinsi: string;
		nama_kabupaten: string;
		nama_kecamatan: string;
		nama_kelurahan: string;
		photo: string;
	}

	// state
	let profile: Profile = $state({
		sekolah: '',
		provinsi: 0,
		kabupaten: 0,
		kecamatan: 0,
		kelurahan: 0,
		photo: ''
	});

	let domisiliStore: DomisiliStore = $state({
		provinsi: [],
		kabupaten: [],
		kecamatan: [],
		kelurahan: []
	});

	let user = $state<{
		nama: string;
		email: string;
	}>({
		nama: '',
		email: ''
	});

	const formData = new FormData();

	// trackers
	let isLoading = $state<boolean>(false);

	// lifecycle
	onMount(async () => {
		try {
			// cek akun user
			const dataUser = (await ngambilData('/user')) as typeof user;
			user = {
				nama: dataUser.nama,
				email: dataUser.email
			};

			// ambil domisili
			domisiliStore = (await ngambilData('/ambildomisili')) as DomisiliStore;

			// mengambil data user profil
			const tempProfile = ((await ngambilData('/ambilprofil')) as ProfileResponse[])[0];
			masukkanDataProfilMentahKeProfilState(tempProfile);
		} catch (error) {
			notifError('gagal ngambil data domisili atau profil :(', 'Silahkan coba lagi yaa...');
		}
	});

	const cekDataDomisili: boolean = $derived.by(() => {
		return !(Object.keys(domisiliStore) as (keyof DomisiliStore)[]).some(
			(key: keyof DomisiliStore) => domisiliStore[key].length === 0
		);
	});

	// function
	function masukkanDataProfilMentahKeProfilState(tempProfile: ProfileResponse) {
		// konversi nama → id
		const prov = domisiliStore.provinsi.find((p) => p.nama_provinsi === tempProfile.nama_provinsi);
		if (prov) profile.provinsi = prov.id;

		const kab = domisiliStore.kabupaten.find(
			(k) => k.nama_kabupaten === tempProfile.nama_kabupaten
		);
		if (kab) profile.kabupaten = kab.id;

		const kec = domisiliStore.kecamatan.find(
			(k) => k.nama_kecamatan === tempProfile.nama_kecamatan
		);
		if (kec) profile.kecamatan = kec.id;

		const kel = domisiliStore.kelurahan.find(
			(k) => k.nama_kelurahan === tempProfile.nama_kelurahan
		);
		if (kel) profile.kelurahan = kel.id;

		profile.sekolah = tempProfile.school;
		profile.photo = base64ToObjectURL(tempProfile.photo) ?? '';
	}

	function ngambilData(path: string) {
		return new Promise((resolve, reject) => {
			api
				.get(path)
				.then((response) => {
					resolve(response.data);
				})
				.catch((error) => {
					console.error(error);
					reject(error);
				});
		});
	}

	// functions
	function cekTipeFile(file: File): boolean {
		return (
			file.type.startsWith('image/') && ['jpeg', 'png'].includes(file.type.split('/').pop() ?? '')
		);
	}

	function convertKeFormData() {
		formData.append('sekolah', profile.sekolah);
		formData.append('provinsi', String(profile.provinsi || ''));
		formData.append('kabupaten', String(profile.kabupaten || ''));
		formData.append('kecamatan', String(profile.kecamatan || ''));
		formData.append('kelurahan', String(profile.kelurahan || ''));
	}

	function kirimDataProfil() {
		isLoading = true;
		return new Promise((resolve, reject) => {
			api
				.post('/kirimprofil', formData)
				.then(() => {
					notifSuccess('profil berhasil disimpan', 'ya gitulah');
					resolve(true);
				})
				.catch((error) => {
					console.error(error);
					notifError(
						'ada yang salah sama di sistem kita atau di input kamu ada yang salah',
						error.response.data.message
					);
					reject(error);
				})
				.finally(() => (isLoading = false));
		});
	}

	// handler
	const handleInputFotoProfil = (
		event: Event & { currentTarget: EventTarget & HTMLInputElement }
	) => {
		const targetSekarang: HTMLInputElement = event.currentTarget as HTMLInputElement;
		const file: File | undefined = targetSekarang.files?.[0];
		if (file) {
			if (!cekTipeFile(file))
				return notifError('Waduh itu tipe file gambarnya harus jpg dong', 'coba input lagi');

			formData.append('photo', file);
			profile.photo = URL.createObjectURL(file);
		}
	};

	const handleSubmit = (e: SubmitEvent & { currentTarget: EventTarget & HTMLFormElement }) => {
		e.preventDefault();

		const apakahAdaInputYangKosong: boolean = Object.values(profile as Record<string, any>).every(
			(val: any) => val === '' || val === 0 || val == null
		);

		if (apakahAdaInputYangKosong)
			return notifError('waduh ada inputan yang kosong', 'coba input lagi');

		convertKeFormData();

		kirimDataProfil();
	};
</script>

<div class="bg-background min-h-screen">
	<!-- navbar -->
	{#if user != null && profile.photo !== ''}
		<Navbar {user} fotoProfil={profile.photo} />
	{/if}

	<div class="mx-auto max-w-6xl p-6">
		<!-- Header -->
		<div class="mb-8">
			<h1 class="text-foreground mb-2 text-3xl font-bold">Profile Settings</h1>
			<p class="text-muted-foreground">Manage your account settings and preferences</p>
		</div>

		<!-- Main Content -->
		<div class="flex gap-8">
			<div class="flex-1">
				<div class="bg-card border-border rounded-lg border p-6">
					<h2 class="text-card-foreground mb-6 text-xl font-semibold">Profile Information</h2>

					<form
						onsubmit={(e: SubmitEvent & { currentTarget: EventTarget & HTMLFormElement }) =>
							handleSubmit(e)}
					>
						<div class="space-y-6">
							<!-- Profile Picture -->
							<div class="flex items-center gap-4">
								<!-- foto -->
								<div class="bg-muted flex h-20 w-20 items-center justify-center rounded-full">
									<img
										src={profile.photo ||
											'https://ui-avatars.com/api/public/default-avatar?size=128'}
										alt="profile"
										class="h-20 w-20 rounded-full"
									/>
								</div>
								<!-- input foto -->
								<div>
									<input
										type="file"
										class="bg-input border-border focus:ring-ring text-foreground w-full cursor-pointer rounded-lg border px-3 py-2 focus:outline-none focus:ring-2"
										accept="image/jpg"
										onchange={(event) => handleInputFotoProfil(event)}
									/>
									<p class="text-muted-foreground mt-1 text-sm">JPG, Max size 2MB.</p>
								</div>
							</div>
							<!-- sekolah -->
							<div class="flex-1">
								<label for="sekolah" class="text-foreground mb-2 block text-sm font-medium"
									>sekolah</label
								>
								<input
									id="sekolah"
									bind:value={profile.sekolah}
									type="input"
									class="bg-input border-border focus:ring-ring text-foreground w-full rounded-lg border px-3 py-2 focus:outline-none focus:ring-2"
								/>
							</div>
							<!-- Domisili -->
							{#if !cekDataDomisili}
								<p>Loading... Lagi ngambil data nih</p>
							{:else}
								<!-- Provinsi -->
								<div class="grid grid-cols-1 gap-6 md:grid-cols-2">
									<div>
										<label for="provinsi" class="text-foreground mb-2 block text-sm font-medium"
											>Provinsi</label
										>
										<select
											id="provinsi"
											bind:value={profile.provinsi}
											class="bg-input border-border focus:ring-ring text-foreground w-full rounded-lg border px-3 py-2 focus:outline-none focus:ring-2"
										>
											{#each domisiliStore.provinsi as provinsi}
												<option value={provinsi.id}>{provinsi.nama_provinsi}</option>
											{/each}
										</select>
									</div>
									<!-- Kabupaten -->
									<div>
										<label for="kabupaten" class="text-foreground mb-2 block text-sm font-medium"
											>Kabupaten</label
										>
										<select
											id="kabupaten"
											bind:value={profile.kabupaten}
											class="bg-input border-border focus:ring-ring text-foreground w-full rounded-lg border px-3 py-2 focus:outline-none focus:ring-2"
										>
											{#each domisiliStore.kabupaten as kabupaten}
												<option value={kabupaten.id}>{kabupaten.nama_kabupaten}</option>
											{/each}
										</select>
									</div>
									<!-- Kecamatan -->
									<div>
										<label for="kecamatan" class="text-foreground mb-2 block text-sm font-medium"
											>Kecamatan</label
										>
										<select
											id="kecamatan"
											bind:value={profile.kecamatan}
											class="bg-input border-border focus:ring-ring text-foreground w-full rounded-lg border px-3 py-2 focus:outline-none focus:ring-2"
										>
											{#each domisiliStore.kecamatan as kecamatan}
												<option value={kecamatan.id}>{kecamatan.nama_kecamatan}</option>
											{/each}
										</select>
									</div>
									<!-- Kelurahan -->
									<div>
										<label for="kelurahan" class="text-foreground mb-2 block text-sm font-medium"
											>Kelurahan</label
										>
										<select
											id="kelurahan"
											bind:value={profile.kelurahan}
											class="bg-input border-border focus:ring-ring text-foreground w-full rounded-lg border px-3 py-2 focus:outline-none focus:ring-2"
										>
											{#each domisiliStore.kelurahan as kelurahan}
												<option value={kelurahan.id}>{kelurahan.nama_kelurahan}</option>
											{/each}
										</select>
									</div>
								</div>
							{/if}
							<!-- tombol simpan perubahan -->
							<div class="flex justify-end pt-4">
								<button
									class="bg-primary text-primary-foreground hover:bg-primary/90 rounded-lg px-6 py-2 transition-colors"
								>
									{#if !isLoading}
										Save Changes
									{:else}
										<Icon icon="line-md:loading-loop" width="24" height="24" />
									{/if}
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
