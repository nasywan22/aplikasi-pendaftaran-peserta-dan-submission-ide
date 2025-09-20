<script lang="ts">
    // SVELTE tools
	import { onMount } from "svelte";

    // axios
	import api from "$lib/axiosConfig";
    import type { AxiosResponse } from "axios";

    // navigation
    import { goto } from "$app/navigation";

    // HOOKS DATA
    let user = $state<any>(null);

    // NON HOOKS DATA
    let isLoading = $state<boolean>(false);

    // check user account
    // HOOK HANDLERS
    onMount(async () => {
        try {
            isLoading = true;
            const response:  AxiosResponse<any, any, {}> = await api.post("/user");
            const data = await response.data;
            
            user = data;
            isLoading = false;
        } catch (error) {
            goto("/logReg?lastPage=formSubmission");
        }
    });
</script>

{#if isLoading}
    <p>Loading...</p>
{:else}
    <p>{user}</p>
     <p>page form submission</p>
{/if}
