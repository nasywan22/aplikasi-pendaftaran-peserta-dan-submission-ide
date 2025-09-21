<script lang="ts">
	// svelte tools
	import { onMount } from 'svelte';

	// .env
	import { PUBLIC_GOOGLE_CAPTCHA_SITE_KEY } from '$env/static/public';
	import { error } from 'console';

	// exported variables (props)
	let { captchaToken } = $props();

	// local static variables
	const siteKey: string = PUBLIC_GOOGLE_CAPTCHA_SITE_KEY;
	let captchaContainer: HTMLDivElement;

	// lifecycle
	onMount(() => {
		loadGoogleCaptchaScript()
			.then(() => renderCaptcha())
			.catch((error) => console.error(error));
	});

	// functions
	function loadGoogleCaptchaScript(): Promise<void> {
		return new Promise((resolve, reject) => {
			const script: HTMLScriptElement = document.createElement('script');
			script.src = 'https://www.google.com/recaptcha/api.js';
			script.async = true;
			script.defer = true;

			script.onload = () => resolve();
			script.onerror = () => reject("gagal ngeload captcha");

			document.head.appendChild(script);
		});
	}

	function renderCaptcha(): void {
		window.grecaptcha.render(captchaContainer, {
			sitekey: siteKey,
			size: 'normal',
			callback: (token: string) => {
				captchaToken = token;
			}
		});
	}
</script>

<div bind:this={captchaContainer}></div>
