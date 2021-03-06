<?php
//
//use Illuminate\Support\Facades\DB;
//use Illuminate\Database\Migrations\Migration;
//
//class FillRegions extends Migration
//{
//    /**
//     * Run the migrations.
//     *
//     * @return void
//     */
//    public function up()
//    {
//        foreach ([
//                     'Республика Адыгея',
//                     'Республика Башкортостан',
//                     'Республика Бурятия',
//                     'Республика Алтай',
//                     'Республика Дагестан',
//                     'Республика Ингушетия',
//                     'Кабардино-Балкарская Республика',
//                     'Республика Калмыкия',
//                     'Республика Карачаево-Черкесия',
//                     'Республика Карелия',
//                     'Республика Коми',
//                     'Республика Марий Эл',
//                     'Республика Мордовия',
//                     'Республика Саха (Якутия)',
//                     'Республика Северная Осетия-Алания',
//                     'Республика Татарстан',
//                     'Республика Тыва',
//                     'Удмуртская Республика',
//                     'Республика Хакасия',
//                     'Чеченская республика',
//                     'Чувашская Республика',
//                     'Алтайский край',
//                     'Краснодарский край',
//                     'Красноярский край',
//                     'Приморский край',
//                     'Ставропольский край',
//                     'Хабаровский край',
//                     'Амурская область',
//                     'Архангельская область',
//                     'Астраханская область',
//                     'Белгородская область',
//                     'Брянская область',
//                     'Владимирская область',
//                     'Волгоградская область',
//                     'Вологодская область',
//                     'Воронежская область',
//                     'Ивановская область',
//                     'Иркутская область',
//                     'Калининградская область',
//                     'Калужская область',
//                     'Камчатский край',
//                     'Кемеровская область',
//                     'Кировская область',
//                     'Костромская область',
//                     'Курганская область',
//                     'Курская область',
//                     'Ленинградская область',
//                     'Липецкая область',
//                     'Магаданская область',
//                     'Московская область',
//                     'Мурманская область',
//                     'Нижегородская область',
//                     'Новгородская область',
//                     'Новосибирская область',
//                     'Омская область',
//                     'Оренбургская область',
//                     'Орловская область',
//                     'Пензенская область',
//                     'Пермский край',
//                     'Псковская область',
//                     'Ростовская область',
//                     'Рязанская область',
//                     'Самарская область',
//                     'Саратовская область',
//                     'Сахалинская область',
//                     'Свердловская область',
//                     'Смоленская область',
//                     'Тамбовская область',
//                     'Тверская область',
//                     'Томская область',
//                     'Тульская область',
//                     'Тюменская область',
//                     'Ульяновская область',
//                     'Челябинская область',
//                     'Забайкальский край',
//                     'Ярославская область',
//                     'г.Москва',
//                     'г.Санкт-Петербург',
//                     'Еврейская автономная область',
//                     'Ненецкий автономный округ',
//                     'Ханты-Мансийский автономный округ - Югра',
//                     'Чукотский автономный округ',
//                     'Ямало-Ненецкий автономный округ',
//                     'Республика Крым',
//                     'г.Севастополь',
//                 ] as $regionName) {
//            DB::table('regions')->insert([
//                'name' => $regionName,
//            ]);
//        }
//    }
//
//    /**
//     * Reverse the migrations.
//     *
//     * @return void
//     */
//    public function down()
//    {
//        //
//    }
//}
