export let domisili = {
    provinsi: [
        {
            id: 1,
            nama_provinsi: 'Aceh',
        },
        {
            id: 2,
            nama_provinsi: 'Sumatera Utara',
        },
        {
            id: 3,
            nama_provinsi: 'Sumatera Selatan',
        },
        {
            id: 4,
            nama_provinsi: 'Jambi',
        },
        {
            id: 5,
            nama_provinsi: 'Bengkulu',
        },
    ],
    kabupaten: [
        {
            id: 1,
            nama_kabupaten: 'Aceh Barat',
            provinsi_id: 1
        },
        {
            id: 2,
            nama_kabupaten: 'Aceh Utara',
            provinsi_id: 1
        },
        {
            id: 3,
            nama_kabupaten: 'Sumatera Utara',
            provinsi_id: 2
        },
        {
            id: 4,
            nama_kabupaten: 'Jambi',
            provinsi_id: 3
        },
        {
            id: 5,
            nama_kabupaten: 'Bengkulu',
            provinsi_id: 4
        }
    ],
    kecamatan: [
        {
            id: 1,
            nama_kecamatan: 'Kecamatan Banda Aceh',
            kabupaten_id: 1
        },
        {
            id: 2,
            nama_kecamatan: 'Kecamatan Lhokseumawe',
            kabupaten_id: 1
        },
        {
            id: 3,
            nama_kecamatan: 'Kecamatan Medan',
            kabupaten_id: 2
        },
        {
            id: 4,
            nama_kecamatan: 'Kecamatan Jambi',
            kabupaten_id: 3
        },
        {
            id: 5,
            nama_kecamatan: 'Kecamatan Bengkulu',
            kabupaten_id: 4
        }
    ],
    kelurahan: [
        {
            id: 1,
            nama_kelurahan: 'Kelurahan Banda Aceh',
            kecamatan_id: 1
        },
        {
            id: 2,
            nama_kelurahan: 'Kelurahan Lhokseumawe',
            kecamatan_id: 1
        },
        {
            id: 3,
            nama_kelurahan: 'Kelurahan Medan',
            kecamatan_id: 2
        },
        {
            id: 4,
            nama_kelurahan: 'Kelurahan Jambi',
            kecamatan_id: 3
        },
        {
            id: 5,
            nama_kelurahan: 'Kelurahan Bengkulu',
            kecamatan_id: 4
        }
    ]
}