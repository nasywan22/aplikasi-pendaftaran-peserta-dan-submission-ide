import api from "$lib/axiosConfig";

export function cekProfilUser(): Promise<boolean> {
    return new Promise((resolve, reject) => {
        api.get('/cekProfil')
            .then(() => {
                resolve(true);
            })
            .catch((error) => {
                reject(error);
            });
    })
}