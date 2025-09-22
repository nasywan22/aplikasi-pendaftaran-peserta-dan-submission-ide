<script lang="ts">
	// shadcn
	import * as AlertDialog from '$lib/components/ui/alert-dialog';

	// props
	let { isOpen = $bindable() } = $props<{ isOpen?: boolean }>();
</script>

<AlertDialog.Root bind:open={isOpen}>
	<AlertDialog.Content>
		<!-- header -->
		<AlertDialog.Header>
			<AlertDialog.Title>Waduh profil kamu masih kosong nih! Isi dulu ya</AlertDialog.Title>
			<AlertDialog.Description>
				informasi profil kamu tuh dibutuhkan buat data formulir nantii...
			</AlertDialog.Description>
		</AlertDialog.Header>

		<!-- footer -->
		<AlertDialog.Footer>
			<AlertDialog.Cancel>hmm... nanti dulu dehh...</AlertDialog.Cancel>
			<a href="/profil">
				<AlertDialog.Action>Pergi ke halaman profil</AlertDialog.Action>
			</a>
		</AlertDialog.Footer>
	</AlertDialog.Content>
</AlertDialog.Root>
