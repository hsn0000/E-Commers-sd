<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'Atribut: harus diterima.',
    'active_url' => 'Atribut: bukan URL yang valid.',
    'after' => 'Atribut: harus berupa tanggal setelah: tanggal.',
    'after_or_equal' => 'Atribut: harus berupa tanggal setelah atau sama dengan: tanggal.',
    'alpha' => 'Atribut: hanya dapat berisi huruf.',
    'alpha_dash' => 'Atribut: hanya dapat berisi huruf, angka, tanda hubung dan garis bawah.',
    'alpha_num' => 'Atribut: hanya dapat berisi huruf dan angka.',
    'array' => 'Atribut: harus berupa array.',
    'before' => 'Atribut: harus tanggal sebelum: tanggal.',
    'before_or_equal' => 'Atribut: harus tanggal sebelum atau sama dengan: tanggal.',
    'between' => [
        'numeric' => 'Atribut: harus antara: min dan: maks.',
        'file' => 'Atribut: harus antara: min dan: maks kilobyte.',
        'string' => 'Atribut: harus antara: min dan: karakter maks.',
        'array' => 'Atribut: harus memiliki antara: min dan: item maks.',
    ],
    'boolean' => 'Bidang: atribut harus benar atau salah.',
    'confirmed' => 'Konfirmasi atribut: tidak cocok.',
    'date' => 'Atribut: bukan tanggal yang valid.',
    'date_equals' => 'Atribut: harus berupa tanggal yang sama dengan: tanggal.',
    'date_format' => 'Atribut: tidak cocok dengan format: format.',
    'different' => 'Atribut: dan: lainnya harus berbeda.',
    'digits' => 'Atribut: harus: digit digit.',
    'digits_between' => 'Atribut: harus antara: min dan: digit maks.',
    'dimensions' => 'Atribut: memiliki dimensi gambar yang tidak valid.',
    'distinct' => 'Bidang: atribut memiliki nilai duplikat.',
    'email' => 'Atribut: harus berupa alamat email yang valid.',
    'ends_with' => 'Atribut: harus diakhiri dengan salah satu dari berikut ini: nilai',
    'exists' => 'Atribut yang dipilih: tidak valid.',
    'file' => 'Atribut: harus berupa file.',
    'filled' => 'Bidang: atribut harus memiliki nilai.',
    'gt' => [
        'numeric' => 'Atribut: harus lebih besar dari: nilai.',
        'file' => 'Atribut: harus lebih besar dari: value kilobytes.',
        'string' => 'Atribut: harus lebih besar dari: karakter nilai.',
        'array' => 'Atribut: harus memiliki lebih dari: item nilai.',
    ],
    'gte' => [
        'numeric' => 'Atribut: harus lebih besar dari atau sama dengan: nilai.',
        'file' => 'Atribut: harus lebih besar dari atau sama dengan: nilai kilobyte.',
        'string' => 'Atribut: harus lebih besar dari atau sama dengan: karakter nilai.',
        'array' => 'Atribut: harus memiliki: item nilai atau lebih.',
    ], 
    'image' => 'Atribut: harus berupa gambar.',
    'in' => 'Atribut yang dipilih: tidak valid.',
    'in_array' => 'Bidang: atribut tidak ada di: other.',
    'integer' => 'Atribut: harus berupa bilangan bulat.',
    'ip' => 'Atribut: harus berupa alamat IP yang valid.',
    'ipv4' => 'Atribut: harus terdiri dari alamat IPv4 yang valid.',
    'ipv6' => 'Atribut: harus alamat IPv6 yang valid.',
    'json' => 'Atribut: harus terdiri dari string JSON yang valid.',
    'lt' => [
        'numeric' => 'Atribut: harus lebih kecil dari: nilai.',
        'file' => 'Atribut: harus kurang dari: nilai kilobyte.',
        'string' => 'Atribut: harus kurang dari: karakter nilai.',
        'array' => 'Atribut: harus memiliki item kurang dari: nilai.',
    ],
    'lte' => [
        'numeric' => 'Atribut: harus kurang dari atau sama dengan: nilai.',
        'file' => 'Atribut: harus kurang dari atau sama: nilai kilobyte.',
        'string' => 'Atribut: harus kurang dari atau sama dengan: karakter nilai.',
        'array' => 'Atribut: tidak boleh memiliki lebih dari: item nilai.',
    ],
    'max' => [
        'numeric' => 'Atribut: mungkin tidak lebih besar dari: maks.',
        'file' => 'Atribut: tidak boleh lebih besar dari: maks kilobyte.',
        'string' => 'Atribut: mungkin tidak lebih besar dari: maks karakter.',
        'array' => 'Atribut: mungkin tidak memiliki lebih dari: item maks.',
    ],
    'mimes' => 'Atribut: harus berupa file type:: values.',
    'mimetypes' => 'Atribut: harus berupa file type:: values.',
    'min' => [
        'numeric' => 'Atribut: setidaknya harus: min.',
        'file' => 'Atribut: setidaknya harus: min kilobyte.',
        'string' => 'Atribut: setidaknya harus: karakter min.',
        'array' => 'Atribut: harus memiliki setidaknya: item min.',
    ],
    'not_in' => 'Atribut yang dipilih: tidak valid.',
    'not_regex' => 'Format atribut: tidak valid.',
    'numeric' => 'Atribut: harus berupa angka.',
    'password' => 'Kata sandi salah.',
    'present' => 'Bidang: atribut harus ada.',
    'regex' => 'Format atribut: tidak valid.',
    'required' => 'Bidang atribut: diperlukan.',
    'required_if' => 'Bidang atribut: diperlukan ketika: lainnya adalah: nilai.',
    'required_unless' => 'Bidang atribut: diperlukan kecuali: yang lain di: nilai.',
    'required_with' => 'Bidang atribut: diperlukan ketika: nilai hadir.',
    'required_with_all' => 'Bidang atribut: diperlukan ketika: nilai ada.',
    'required_without' => 'Bidang atribut: diperlukan ketika: nilai tidak ada.',
    'required_without_all' => 'Bidang atribut: diperlukan ketika tidak ada: nilai hadir.',
    'same' => 'Atribut: dan: lainnya harus cocok.',
    'size' => [
        'numeric' => 'Atribut: harus: size.',
        'file' => 'Atribut: harus: size kilobytes.',
        'string' => 'Atribut: harus: karakter ukuran.',
        'array' => 'Atribut: harus berisi: item ukuran.',
    ],
    'starts_with' => 'Atribut: harus berupa string',
    'string' => 'Atribut: harus berupa string.',
    'timezone' => 'Atribut: harus merupakan zona yang valid.',
    'unique' => 'Atribut: telah diambil.',
    'uploaded' => 'Atribut: gagal diunggah.',
    'url' => 'Format atribut: tidak valid.',
    'uuid' => 'Atribut: harus UUID yang valid.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    // logout admin
    'are_you_sure' => 'តើអ្នកប្រាកដទេ?',
    'you_want_to_logout_this_page' => 'អ្នកចង់ចាកចេញពីទំព័រនេះ!',
    'yes_logout_it' => 'បាទចេញ!',
    'logout_Page' => 'ចេញពីទំព័រ!',
    'your_has_been_logout_this_page' => 'អ្នកបានចាកចេញពីទំព័រនេះហើយ.',
    'success' => 'វាដំណើរការ !',

    // delete category
    'you_want_to_delete_this' => 'អ្នកចង់លុបវាចោល',
    'yes_delete_it' => 'ត្រូវហើយលុបវាចោល',
    'no_cancel' => 'ទេបោះបង់វាចោល',
    'deleted' => 'បានលុបចោល!',
    'your' => 'អ្នក',
    'has_been_deleted' => 'ត្រូវបានលុបចោល.',
    'cancelled' => 'បោះបង់',
    'is_safe' => 'មានសុវត្ថិភាព :',

    // delete attribute
    'you_want_to_delete_this_attribute' => 'អ្នកចង់លុបគុណលក្ខណៈនេះចោល?',
    'your_attribute_has_been_deleted' => 'គុណលក្ខណៈរបស់អ្នកត្រូវបានលុបចោល។', 
    'your_attribute_is_safe' => 'គុណលក្ខណៈរបស់អ្នកមានសុវត្ថិភាព',
   
    // delete product
    'you_want_to_delete_this' => 'អ្នកចង់លុបវាចោល',

    // delete alternate images
    'you_want_to_delete_this_images' => 'តើអ្នកចង់លុបរូបភាពនេះទេ?',
    'your_images_has_been_deleted' => 'រូបភាពរបស់អ្នកត្រូវបានលុបចោល.',
    'your_images_is_safe' => 'រូបភាពរបស់អ្នកមានសុវត្ថិភាព',

    // admin setting passwr
    'passIncorect' => 'លេខសំងាត់បច្ចុប្បន្នមិនត្រឹមត្រូវ',
    'passIscorrect' => 'លេខសំងាត់បច្ចុប្បន្នពិត',

    // password validate admin
    'please_enter_your_current_password' => 'សូមបញ្ចូលពាក្យសម្ងាត់បច្ចុប្បន្នរបស់អ្នក',
    'your_password_must_be_atleast_6_characters_long' => 'ពាក្យសម្ងាត់របស់អ្នកត្រូវមានយ៉ាងហោចណាស់ ៦ តួអក្សរ',
    'your_password_must_be_at_most_20_characters' => 'ពាក្យសម្ងាត់របស់អ្នកត្រូវមានយ៉ាងហោចណាស់ ២០ តួអក្សរ',
    'please_enter_your_new_password' => 'សូមបញ្ចូលពាក្យសម្ងាត់ថ្មីរបស់អ្នក',
    'please_confirm_your_new_password' => 'សូមបញ្ជាក់ពាក្យសម្ងាត់ថ្មីរបស់អ្នក',
    'your_password_is_not_the_same' => 'ពាក្យសម្ងាត់របស់អ្នកមិនដូចគ្នាទេ',

    'attributes' => [],



];
