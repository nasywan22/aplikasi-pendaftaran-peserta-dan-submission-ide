import { toast } from "svelte-sonner";

export function notifSuccess(pesan: string, deskripsi: string) {
	toast.success(pesan, {
		description: deskripsi,
		duration: 5000,
		position: 'top-center'
	});
}

export function notifError(pesan: string, deskripsi: string) {
	toast.error(pesan, {
		description: deskripsi,
		duration: 5000,
		position: 'top-center'
	});
}
