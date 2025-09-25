<script lang="ts">
	// svelte tools
	import { onMount } from 'svelte';
	import { goto } from '$app/navigation';

	// icons
	import Icon from '@iconify/svelte';

	// import milik sendiri
	import { cekProfilUser } from '$lib/scripts/cekProfilUser';
	import Navbar from '$lib/components/Navbar.svelte';
	import { notifError, notifSuccess } from '$lib/scripts/notif';
	import api from '$lib/axiosConfig';
	import { cekAkunUser } from '$lib/scripts/cekAkunUser';

	// state
	const formData = $state<{
		judul: string;
		deskripsi: string;
	}>({
		judul: '',
		deskripsi: ''
	});

	let user = $state<{
		nama: string;
		email: string;
	}>({
		nama: '',
		email: ''
	});

	const formdata = new FormData();

	// lifecycle
	onMount(() => {
		cekAkunUser()
			.then((akun) => (user = akun))
			.catch(() => goto('/logReg'));
		cekProfilUser().catch(() => goto('/formSubmission'));
	});

	// handler
	function handleSubmit() {
		if (!formData.judul && !formData.deskripsi)
			return notifError('Input kamu ada yang kosong nih', 'isi dulu yaa');

		// pindahin ke FormData
		// versi ribet
		// (Object.keys(formData) as (keyof typeof formData)[]).map((key) =>
		// 	formdata.append(key, formData[key])
		// );

		// versi simple
		formdata.append('judul', formData.judul);
		formdata.append('deskripsi', formData.deskripsi);

		// kirim form
		api
			.post('/kiriminovasi', formdata)
			.then((response) => notifSuccess(response.data.message, 'kalo mau kirim lagi silahkan'))
			.catch((error) => notifError('Waduh ada yang salah nih', error));
	}

	function handleFileUpload(event: Event & { currentTarget: EventTarget }) {
		const inputFile = event.target as HTMLInputElement;
		if (!inputFile) return;

		const files = inputFile.files;
		if (!files) return notifError('file nya ngga ada', 'tolong input filenya ya');

		if (files[0].type.split('/').pop() !== 'pdf')
			return notifError('Tipe filenya cuman bisa pdf yaa...', 'silahkan input ulang filenya');

		formdata.append('proposal', files[0]);
	}
</script>

<!-- navbar -->
<Navbar {user} />

<div class="mx-auto max-w-4xl px-6 py-12">
	<!-- Header -->
	<div class="mb-12">
		<div class="mb-6 flex items-center gap-3">
			<div class="bg-primary h-8 w-8 rounded"></div>
			<span class="text-lg font-medium">Innovation Portal</span>
		</div>

		<h1 class="mb-4 text-balance text-4xl font-bold">Submit Your Innovation Idea</h1>
		<p class="text-muted-foreground max-w-2xl text-pretty text-lg">
			Share your innovative ideas and help drive positive change. Complete the form below to submit
			your proposal for review.
		</p>
	</div>

	<!-- Form Content -->
	<div class="border-border mb-8 rounded-lg border p-8">
		<div class="space-y-8">
			<div class="grid grid-cols-1 gap-6 md:grid-cols-2">
				<div class="md:col-span-2">
					<label for="judul" class="mb-2 block text-sm font-medium">Innovation Title *</label>
					<input
						type="text"
						bind:value={formData.judul}
						id="judul"
						placeholder="Enter a clear, descriptive title for your innovation"
						class="border-input focus:ring-ring w-full rounded-md border px-4 py-3 focus:outline-none focus:ring-2"
					/>
				</div>

				<div class="md:col-span-2">
					<label for="description" class="mb-2 block text-sm font-medium">Brief Description *</label
					>
					<textarea
						bind:value={formData.deskripsi}
						id="deskripsi"
						placeholder="Provide a concise overview of your innovation idea (2-3 sentences)"
						rows="4"
						class="border-input focus:ring-ring w-full resize-none rounded-md border px-4 py-3 focus:outline-none focus:ring-2"
					></textarea>
				</div>

				<div class="md:col-span-2">
					<label for="proposal" class="mb-2 block text-sm font-medium">Lampiran file proposal</label
					>
					<input
						type="file"
						accept="application/pdf"
						placeholder="Input a file"
						onchange={(e) => handleFileUpload(e)}
						class="border-input focus:ring-ring w-full resize-none rounded-md border px-4 py-3 focus:outline-none focus:ring-2"
					/>
				</div>
			</div>
		</div>
	</div>

	<!-- submit Buttons -->
	<div class="flex items-center justify-between">
		<button
			onclick={handleSubmit}
			class="bg-primary text-primary-foreground hover:bg-primary/90 rounded-md px-8 py-3 font-medium transition-colors"
		>
			Submit Innovation
		</button>
	</div>

	<!-- Help Text -->
	<div class="bg-muted mt-12 rounded-lg p-6">
		<h3 class="mb-2 font-medium">Need Help?</h3>
		<p class="text-muted-foreground text-sm">
			If you have questions about the submission process or need assistance with your innovation
			proposal, contact our innovation team at <span class="font-medium"
				>innovation@company.com</span
			>
			or visit our
			<span class="cursor-pointer font-medium underline">help center</span>.
		</p>
	</div>
</div>
