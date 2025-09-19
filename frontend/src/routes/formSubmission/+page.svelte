<script lang="ts">
    // SVELTE tools
	import { onMount } from "svelte";

    // axios
    import axios from "axios";
    import type { AxiosResponse } from "axios";

    // navigation
    import { goto } from "$app/navigation";

    // NON HOOKS DATA
    let isLoading = $state<boolean>(false);

    // check user account
    // HOOK HANDLERS
    onMount(async () => {
        try {
            isLoading = true;
            const response:  AxiosResponse<any, any, {}> = await axios.post("http://localhost:8000/api/usercheck");
        } catch (error) {
            goto("/logReg?lastPage=formSubmission");
        }
    });
</script>

{#if isLoading}
    <p>Loading...</p>
{:else}
     <p>page form submission</p>
{/if}
