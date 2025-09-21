declare global {
	interface Window {
		grecaptcha: {
			ready(callback: () => void): void;
			execute(siteKey: string, options: { action: string }): Promise<string>;
			render(
				container: string | HTMLElement,
				parameters: {
					sitekey: string;
					size: 'invisible' | 'normal' | 'compact';
					callback?: (token: string) => void;
					'error-callback'?: () => void;
				}
			): number;
			reset(): void;
		};
		onCaptchaLoad?: () => void;
	}
}

export {};
