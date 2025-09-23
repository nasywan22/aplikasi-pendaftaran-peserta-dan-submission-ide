<script lang="ts">
	import '../app.css';
	import { Toaster } from '$lib/components/ui/sonner/index';
	import { ambilCSRFTokenDariLaravel } from '$lib/scripts/ambilCSRFToken';

	let { children } = $props();

	// function
	async function ambilCookie() {
		try {
			await ambilCSRFTokenDariLaravel();
		} catch (error) {
			console.error(`Gagal mengambil xsrf token dari laravel. Error: ${error}`);
		}
	}

	ambilCookie();
</script>

<Toaster />
{@render children()}