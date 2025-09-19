<script>
	import '../app.css';
	import Toaster from './../../node_modules/svelte-sonner/dist/Toaster.svelte';
	let { children } = $props();
</script>

<Toaster />
{@render children()}