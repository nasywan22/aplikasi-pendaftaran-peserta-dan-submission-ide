<script lang="ts">
    // svelte tools
	import { onMount } from "svelte";
    import { goto } from "$app/navigation";

    // import milik sendiri
    import { cekProfilUser } from "$lib/scripts/cekProfilUser";
    
    // lifecycle
    onMount(() => {
        cekProfilUser().catch(() => goto('/formSubmission'));
    })
</script>

<p>form</p>