<?php

use Illuminate\Database\Seeder;

class Products extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('products')->insert([
            [
                'category_id' => 2,
                'product_name' => 'Desember punya gaya',
                'product_code' => 'S-32',
                'product_color' => 'Red',
                'care' => '<h3><b>Desember punya gaya bro&nbsp;<a target="_blank" rel="nofollow" href="http://oke.co.id">http://oke.co.id/</a></b></h3><ol><li>Pilih Warna dan Ukuran Secara Teliti di Bagian Variasi / Opsi Produk – Pilih Tambah Troli</li><li>Mohon Mengecek Terlebih Dahulu Pesanan Anda Di Troli Belanja Untuk Menghindari Kesalahan Pesanan</li><li>Silahkan Chat Live Ke Kami Toko JET untuk Pertanyaan Dan Keluhan&nbsp;di Hari / Jam Kerja = Senin – Sabtu Pukul 08.00 WIB&nbsp;– 16.00 WIB</li><li>Terima kasih telah melihat / membeli produk - produk kami – JET</li><li><img alt="" src="http://https://cdn-image.hipwee.com/wp-content/uploads/2016/04/hipwee-nenek-750x583.jpg"><img alt="" src="http://https://cdn-image.hipwee.com/wp-content/uploads/2016/04/hipwee-nenek-750x583.jpg"><img alt="" src="https://i.pinimg.com/originals/f7/ec/58/f7ec58e519fcdc4444b662b92cc8c38b.jpg"><br></li></ol><img alt="" src="http://https://cdn-image.hipwee.com/wp-content/uploads/2016/04/hipwee-nenek-750x583.jpg"><br><ol><div><div><div><div></div><div></div><div><div><div></div></div><div><div><div><div><div></div></div></div></div></div></div></div></div></div></ol>',
                'sleeve' => 'Short Sleeve',
                'pattern' => 'Printed',
                'description' => '<h3><b>Desember punya kita kita</b></h3><b>S E S U A I&nbsp;&nbsp;&nbsp;&nbsp; F O T O &nbsp;= &nbsp;Lengan Ada Karet</b><br>SELALU READY STOCK – STOK BANYAK &nbsp;= &nbsp;Langsung saja di order<br>Bisa Bayar Di Tempat – Tersedia 22 Warna<br>Bahan Lacos / Pique Poliester = Nyaman Dan Santai Di Segala Aktifitas<br>Tersedia Ukuran S – M – L – XL – XXL – XXXL<br>Kami Langsung Kirim Di Hari Yang Sama Ke Jasa Pengiriman (Kurang Dari 24 jam)<br>',
                'price' => '140000',
                'weight' => '200',
                'image' => '74515.jpg',
                'video' => 'Modeling Baju JAMDA 3 YRKI Jateng..mp4',
                'feature_item' => 1,
                'status' => 1,
                'created_at' => now()
            ],
            [
                'category_id' => 2,
                'product_name' => 'Naruto Ujumaki',
                'product_code' => 'U-098',
                'product_color' => 'White',
                'care' => 'Ichiraku Ramen west',
                'sleeve' => 'Half Sleeve',
                'pattern' => 'Plain',
                'description' => 'Ichiraku Ramen, half sleeves',
                'price' => '120000',
                'weight' => '150',
                'image' => '85680.jpg',
                'video' => '',
                'feature_item' => 1,
                'status' => 1,
                'created_at' => now()
            ],
            [
                'category_id' => 4,
                'product_name' => 'Formal Black End',
                'product_code' => 'B-076',
                'product_color' => 'Black',
                'care' => 'This product is build pure cotton.',
                'sleeve' => 'Half Sleeve',
                'pattern' => 'Solid',
                'description' => 'Black Formal, has a round neck , half sleeves',
                'price' => '150000',
                'weight' => '100',
                'image' => '10665.jpg',
                'video' => 'y2mate.com - Model Terbaru Hijab Remaja Anak Muda 2018 2019 - Busana Muslim Anak Muda Gaul Dan Modis_2AwinGJ4gwc_360p.mp4',
                'feature_item' => 1,
                'status' => 1,
                'created_at' => now()
            ],
            [
                'category_id' => 4,
                'product_name' => 'model long dress',
                'product_code' => 'M-345',
                'product_color' => 'Gray',
                'care' => 'model long dress womans sweet',
                'sleeve' => 'Full Sleeve',
                'pattern' => 'Checked',
                'description' => 'Koko sitrume wangi terpercaya',
                'price' => '230000.00',
                'weight' => '100',
                'image' => '61301.jpg',
                'video' => '',
                'feature_item' => 1,
                'status' => 1,
                'created_at' => now()
            ]
        ]);
    }
}
