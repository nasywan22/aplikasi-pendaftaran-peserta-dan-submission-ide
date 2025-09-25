<script>
	import * as Dropdown from '$lib/components/ui/dropdown-menu';
	import Icon from '@iconify/svelte';
	import { goto } from '$app/navigation';

	// import milik sendiri
	import api from '$lib/axiosConfig';

	// handler
	const handleLogOut = () => {
		api
			.post('/logout')
			.then(() => {
				goto('/logReg');
			})
			.catch((error) => {
				console.error(error);
			});
	};
</script>

<Dropdown.Root>
	<Dropdown.Trigger>
		<Icon icon="iconamoon:arrow-down-2-light" width="20" height="20" />
	</Dropdown.Trigger>
	<Dropdown.Content>
		<Dropdown.Content>
			<Dropdown.Group>
				<Dropdown.Label>My Account</Dropdown.Label>
				<Dropdown.Separator />
				<a href="/profil">
					<Dropdown.Item>Profile</Dropdown.Item>
				</a>
				<Dropdown.Item>Billing</Dropdown.Item>
				<Dropdown.Item>Team</Dropdown.Item>
				<Dropdown.Item>Subscription</Dropdown.Item>
				<Dropdown.Separator />
				<Dropdown.Item class="text-red-500" onclick={() => handleLogOut()}>Logout</Dropdown.Item>
			</Dropdown.Group>
		</Dropdown.Content>
	</Dropdown.Content>
</Dropdown.Root>
