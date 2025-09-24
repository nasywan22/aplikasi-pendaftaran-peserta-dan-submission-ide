// Fungsi Convert Base64 ke Blob
function base64ToBlob(base64String: string, contentType: string = 'image/jpeg'): Blob | null {
	try {
		// Hapus prefix data URL jika ada
		const base64Data = base64String.replace(/^data:image\/\w+;base64,/, '');

		// Decode Base64 ke binary
		const byteCharacters = atob(base64Data);
		const byteArrays: BlobPart[] = [];

		// Convert ke array buffer
		for (let offset = 0; offset < byteCharacters.length; offset += 512) {
			const slice = byteCharacters.slice(offset, offset + 512);
			const byteNumbers = new Array(slice.length);

			for (let i = 0; i < slice.length; i++) {
				byteNumbers[i] = slice.charCodeAt(i);
			}

			const byteArray = new Uint8Array(byteNumbers);
			byteArrays.push(byteArray);
		}

		// Buat Blob
		const blob = new Blob(byteArrays, { type: contentType });
		return blob;
	} catch (error) {
		console.error('Error converting Base64 to Blob:', error);
		return null;
	}
}

// Fungsi Convert Base64 ke Object URL
export function base64ToObjectURL(
	base64String: string,
	contentType: string = 'image/jpeg'
): string | null {
	try {
		const blob = base64ToBlob(base64String, contentType);
		if (!blob) return null;

		// Buat Object URL
		const objectURL = URL.createObjectURL(blob);
		return objectURL;
	} catch (error) {
		console.error('Error creating Object URL:', error);
		return null;
	}
}

// Fungsi Convert Base64 ke Data URL (Langsung untuk img src)
export function base64ToDataURL(
	base64String: string,
	contentType: string = 'image/jpeg'
): string | null {
	try {
		// Jika sudah ada prefix data URL, return langsung
		if (base64String.startsWith('data:')) {
			return base64String;
		}

		// Tambahkan prefix data URL
		return `data:${contentType};base64,${base64String}`;
	} catch (error) {
		console.error('Error creating Data URL:', error);
		return null;
	}
}

// Fungsi Auto Detect Content Type
function detectContentType(base64: string): string {
	if (base64.startsWith('/9j') || base64.startsWith('iVBORw0KGgo')) {
		return 'image/jpeg';
	} else if (base64.startsWith('iVBORw0KGgo')) {
		return 'image/png';
	} else if (base64.startsWith('R0lGODlh')) {
		return 'image/gif';
	} else if (base64.startsWith('UklGR')) {
		return 'image/webp';
	} else {
		return 'image/jpeg'; // default
	}
}

// Fungsi All-in-One dengan Auto Detect Content Type
export function base64ToImage(
	base64String: string,
	outputType: 'blob' | 'objectURL' | 'dataURL' = 'dataURL'
): Blob | string | null {
	const contentType = detectContentType(base64String);

	switch (outputType) {
		case 'blob':
			return base64ToBlob(base64String, contentType);

		case 'objectURL':
			return base64ToObjectURL(base64String, contentType);

		case 'dataURL':
		default:
			return base64ToDataURL(base64String, contentType);
	}
}

// Fungsi Cleanup Object URL (Penting!)
export function revokeObjectURL(url: string): void {
	if (url && url.startsWith('blob:')) {
		URL.revokeObjectURL(url);
	}
}

// Export juga fungsi base64ToBlob jika diperlukan di tempat lain
export { base64ToBlob };
