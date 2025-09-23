<script lang="ts">
	// svelte tools
	import { onMount } from 'svelte';

	// import milik sendiri
	import Navbar from '$lib/components/Navbar.svelte';
	import { notifError } from '$lib/scripts/notif';
	import api from '$lib/axiosConfig';

	// dummy data
	import { domisili } from './dummyUserProfile';

	// type
	interface DomisiliStore {
		provinsi: Array<{ id: number; nama_provinsi: string }>;
		kabupaten: Array<{ id: number; nama_kabupaten: string; provinsi_id: number }>;
		kecamatan: Array<{ id: number; nama_kecamatan: string; kabupaten_id: number }>;
		kelurahan: Array<{ id: number; nama_kelurahan: string; kecamatan_id: number }>;
	}

	interface Profile {
		name: string;
		sekolah: string;
		provinsi: string;
		kabupaten: string;
		kecamatan: string;
		kelurahan: string;
		photo: string;
	}

	// state
	let profile: Profile = $state({
		name: '',
		sekolah: '',
		provinsi: '',
		kabupaten: '',
		kecamatan: '',
		kelurahan: '',
		photo: ''
	});

	let domisiliStore: DomisiliStore = $state({
		provinsi: [],
		kabupaten: [],
		kecamatan: [],
		kelurahan: []
	});

	// lifecycle
	onMount(async () => {
		try {
			domisiliStore = await ngambilDomisili();
		} catch (error) {
			notifError('gagal ngambil data domisili :(', 'Silahkan coba lagi yaa...');
		}
	});

	const cekDataDomisili: boolean = $derived.by(() => {
		return !(Object.keys(domisiliStore) as (keyof DomisiliStore)[]).some(
			(key: keyof DomisiliStore) => domisiliStore[key].length === 0
		);
	});

	// function
	function ngambilDomisili(): Promise<DomisiliStore> {
		return new Promise((resolve, reject) => {
			api
				.get('/ambildomisili')
				.then((response) => {
					resolve(response.data);
				})
				.catch((error) => {
					console.error(error);
					reject(error);
				});
		});
	}

	function cekTipeFile(file: File): boolean {
		return file.type.startsWith('image/') && file.type.split('/').pop() === 'jpeg';
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

			const reader = new FileReader();

			reader.onload = (e) => {
				profile.photo = e.target?.result as string;
			};

			reader.readAsDataURL(file);
		}
	};
</script>

<div class="bg-background min-h-screen">
	<!-- navbar -->
	<Navbar />

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

					<div class="space-y-6">
						<!-- Profile Picture -->
						<div class="flex items-center gap-4">
							<!-- foto -->
							<div class="bg-muted flex h-20 w-20 items-center justify-center rounded-full">
								<img
									src={profile.photo || 'https://ui-avatars.com/api/public/default-avatar?size=128'}
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

						<!-- Form Fields -->
						<div class="grid grid-cols-1 gap-6 md:grid-cols-2">
							<!-- Full Name -->
							<div>
								<label for="fullName" class="text-foreground mb-2 block text-sm font-medium"
									>Full Name</label
								>
								<input
									id="fullName"
									bind:value={profile.name}
									type="text"
									class="bg-input border-border focus:ring-ring text-foreground w-full rounded-lg border px-3 py-2 focus:outline-none focus:ring-2"
								/>
							</div>

							<!-- sekolah -->
							<div>
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
						</div>

						<!-- Domisili -->
						{#if !cekDataDomisili}
						<p>Loading... Lagi ngambil data nih</p>
						{:else}
						<!-- Provinsi -->
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
										<option value={provinsi.nama_provinsi}>{provinsi.nama_provinsi}</option>
									{/each}
								</select>
							</div>

							<div class="grid grid-cols-1 gap-6 md:grid-cols-2">
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
											<option value={kabupaten.nama_kabupaten}>{kabupaten.nama_kabupaten}</option>
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
											<option value={kecamatan.nama_kecamatan}>{kecamatan.nama_kecamatan}</option>
										{/each}
									</select>
								</div>
							</div>

							<!-- Kelurahan -->
							<div class="grid grid-cols-1 gap-6 md:grid-cols-2">
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
											<option value={kelurahan.nama_kelurahan}>{kelurahan.nama_kelurahan}</option>
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
								Save Changes
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
