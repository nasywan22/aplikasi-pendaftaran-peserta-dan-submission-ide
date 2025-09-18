<script>
	import { onMount } from "svelte";
    import axios from "axios";
    import { goto } from "$app/navigation";

    // check user account
    onMount(async () => {
        try {
            const response = await axios.post("http://localhost:8000/api/usercheck");
        } catch (error) {
            goto("/logReg");
        }
    });
</script>

<p>page form submission</p>