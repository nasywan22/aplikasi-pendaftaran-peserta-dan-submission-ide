<script lang="ts">
	// import dan komponent milik sendiri
	import api from '$lib/axiosConfig';

	import Header from '../lib/components/Navbar.svelte';
	import HeroSection from '../lib/components/HeroSection.svelte';
	import FeaturesSection from '../lib/components/FeaturesSection.svelte';
	import Footer from '../lib/components/Footer.svelte';

	// svelte tools
	import type { AxiosResponse } from 'axios';
	import { onMount } from 'svelte';

	// HOOKS DATA
	let user = $state<{
		nama: string;
		email: string;
	}>({
		nama: '',
		email: ''
	});

	// lifesycle
	onMount(async () => {
		try {
			const response: AxiosResponse<any, any, {}> = await api.get('/user');

			const data: {
				nama: string;
				email: string;
			} = {
				nama: response.data.name,
				email: response.data.email
			};

			user = data;
		} catch (error) {}
	});
</script>

<div class="bg-background min-h-screen">
	{#if user.nama}
		<Header {user} />
	{:else}
		<Header />
	{/if}
	<main>
		<HeroSection />
		<FeaturesSection />
	</main>
	<Footer />
</div>
