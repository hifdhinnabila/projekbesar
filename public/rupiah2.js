// Fungsi untuk memformat angka menjadi format Rupiah (Rp xxx.xxx,xx)
function formatRupiah(angka, prefix){
    // Mengubah angka ke string dan menghapus semua karakter selain angka dan koma
    var number_string = angka.toString().replace(/[^,\d]/g, '').toString(),
    // Memisahkan angka utama dan angka desimal (setelah koma)
        split    = number_string.split(','),
        // Menghitung sisa panjang karakter sebelum digit pertama ribuan
        sisa = split[0].length % 3,
        // Menyimpan bagian awal angka sebelum ribuan
        rupiah = split[0].substr(0, sisa),
        // Mengambil kelompok 3 angka setelah bagian awal
        ribuan     = split[0].substr(sisa).match(/\d{3}/gi);
        
    // Jika ada ribuan, tambahkan titik pemisah
    if (ribuan) {
        // Jika ada sisa di depan, tambahkan titik setelahnya
        separator = sisa ? '.' : '';
        // Gabungkan sisa + titik + ribuan
        rupiah += separator + ribuan.join('.');
    }
    
    // Tambahkan angka desimal (jika ada), pakai koma sebagai pemisah
    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

    // Kembalikan hasil format dengan atau tanpa prefix (Rp)
    return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
}
 
