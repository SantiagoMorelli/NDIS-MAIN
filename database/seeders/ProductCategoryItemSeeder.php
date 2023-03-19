<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ProductCategoryItems;

class ProductCategoryItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	ProductCategoryItems::truncate();

    	$data = [
			[
				'item_name' 	=> 'Disability-Related Health Consumables - Low Cost',
				'item_number'	=> '03_040000919_0103_1_1',
				'category_name' => 'CONSUMABLES',
			],
			[
				'item_name' 	=> 'Low Cost AT - Prosthetics And Orthotics',
				'item_number'	=> '03_060000911_0135_1_1',
				'category_name' => 'CONSUMABLES',
			],
			[
				'item_name' 	=> 'Low Cost AT - Personal Care And Safety',
				'item_number'	=> '03_090000911_0103_1_1',
				'category_name' => 'CONSUMABLES',
			],
			[
				'item_name' 	=> 'Continence Products Urinary - Other For Child',
				'item_number'	=> '03_092488056_0103_1_1',
				'category_name' => 'CONSUMABLES',
			],
			[
				'item_name' 	=> 'Continence Products Urinary - Other For Adult',
				'item_number'	=> '03_092489060_0103_1_1',
				'category_name' => 'CONSUMABLES',
			],
			[
				'item_name' 	=> 'Adult Absorbent Pull Up Or Brief 3/Day - Annual Supply',
				'item_number'	=> '03_093021074_0103_1_1',
				'category_name' => 'CONSUMABLES',
			],
			[
				'item_name' 	=> 'Adult Absorbent Pull Up Or Brief 4/Day - Annual Supply',
				'item_number'	=> '03_093021075_0103_1_1',
				'category_name' => 'CONSUMABLES',
			],
			[
				'item_name' 	=> 'Adult Absorbent Pull Up Or Brief 6/Day - Annual Supply',
				'item_number'	=> '03_093021076_0103_1_1',
				'category_name' => 'CONSUMABLES',
			],
			[
				'item_name' 	=> 'Adult Absorbent Pull Up Or Brief 12/Day - Annual Supply',
				'item_number'	=> '03_093021077_0103_1_1',
				'category_name' => 'CONSUMABLES',
			],
			[
				'item_name' 	=> 'Low Cost AT - Personal Mobility',
				'item_number'	=> '03_120000911_0105_1_1',
				'category_name' => 'CONSUMABLES',
			],
			[
				'item_name' 	=> 'Standing AND/OR Walking Frame - Child',
				'item_number'	=> '05_053603131_0103_1_2',
				'category_name' => 'ASSISTIVE_TECHNOLOGY',
			],
			[
				'item_name' 	=> 'Cervico-Thoraco-Lumbo-Sacral Orthoses',
				'item_number'	=> '05_060318121_0135_1_2',
				'category_name' => 'ASSISTIVE_TECHNOLOGY',
			],
			[
				'item_name' 	=> 'Orthosis - Upper Limb - Prefabricated',
				'item_number'	=> '05_060600111_0135_1_2',
				'category_name' => 'ASSISTIVE_TECHNOLOGY',
			],
			[
				'item_name' 	=> 'Orthosis - Ankle Foot (AFO) - Prefabricated',
				'item_number'	=> '05_061206111_0135_1_2',
				'category_name' => 'ASSISTIVE_TECHNOLOGY',
			],
			[
				'item_name' 	=> 'Orthosis - Knee - Prefabricated',
				'item_number'	=> '05_061209111_0105_1_2',
				'category_name' => 'ASSISTIVE_TECHNOLOGY',
			],
			[
				'item_name' 	=> 'Orthosis - Bilateral Hip Knee Ankle Foot Orthosis (Rgo) - Prefabricated',
				'item_number'	=> '05_061218221_0135_1_2',
				'category_name' => 'ASSISTIVE_TECHNOLOGY',
			],
			[
				'item_name' 	=> 'Assistive Products and Accessories for Personal Care Hygiene Beds',
				'item_number'	=> '05_090000111_0103_1_2',
				'category_name' => 'ASSISTIVE_TECHNOLOGY',
			],
			[
				'item_name' 	=> 'Toilet Attachments and Accessories',
				'item_number'	=> '05_091200111_0103_1_2',
				'category_name' => 'ASSISTIVE_TECHNOLOGY',
			],
			[
				'item_name' 	=> 'Mobile Shower Commode - Low Transporter',
				'item_number'	=> '05_091203053_0103_1_2',
				'category_name' => 'ASSISTIVE_TECHNOLOGY',
			],
			[
				'item_name' 	=> 'Personal Care AND Safety Equipment - Other',
				'item_number'	=> '05_098800044_0103_1_2',
				'category_name' => 'ASSISTIVE_TECHNOLOGY',
			],
			[
				'item_name' 	=> 'Wheeled Walker - Standard',
				'item_number'	=> '05_120606096_0105_1_2',
				'category_name' => 'ASSISTIVE_TECHNOLOGY',
			],
			[
				'item_name' 	=> 'Rollator - Standard',
				'item_number'	=> '05_120606097_0105_1_2',
				'category_name' => 'ASSISTIVE_TECHNOLOGY',
			],
			[
				'item_name' 	=> 'Walking Frame OR Walker',
				'item_number'	=> '05_120606111_0105_1_2',
				'category_name' => 'ASSISTIVE_TECHNOLOGY',
			],
			[
				'item_name' 	=> 'Rollator - Standard - Child',
				'item_number'	=> '05_120606131_0105_1_2',
				'category_name' => 'ASSISTIVE_TECHNOLOGY',
			],
			[
				'item_name' 	=> 'Scooter: Indoor/Outdoor USE',
				'item_number'	=> '05_122303111_0105_1_2',
				'category_name' => 'ASSISTIVE_TECHNOLOGY',
			],
			[
				'item_name' 	=> 'Wheelchair - Powered With Powered Standing Mechanism',
				'item_number'	=> '05_122306139_0105_1_2',
				'category_name' => 'ASSISTIVE_TECHNOLOGY',
			],
			[
				'item_name' 	=> 'Assistive Products And Accessories Relating To Participating In Household Tasks',
				'item_number'	=> '05_150000111_0123_1_2',
				'category_name' => 'ASSISTIVE_TECHNOLOGY',
			],
			[
				'item_name' 	=> 'AT Rental - Assistive Products for Household Tasks',
				'item_number'	=> '05_150000115_0123_1_2',
				'category_name' => 'ASSISTIVE_TECHNOLOGY',
			],
			[
				'item_name' 	=> 'Custom Sleep Positioning System and Accessories',
				'item_number'	=> '05_181224711_0103_1_2',
				'category_name' => 'ASSISTIVE_TECHNOLOGY',
			],
			[
				'item_name' 	=> 'Voice Amplifiers For Personal Use',
				'item_number'	=> '05_220906234_0124_1_2',
				'category_name' => 'ASSISTIVE_TECHNOLOGY',
			],
			[
				'item_name' 	=> 'Safety: Slip Resistance Coating/Grab And/or Guide Rails',
				'item_number'	=> '05_221200111_0111_2_2',
				'category_name' => 'ASSISTIVE_TECHNOLOGY',
			],
			[
				'item_name' 	=> 'Communication - Amplifiers',
				'item_number'	=> '05_222106253_0124_1_2',
				'category_name' => 'ASSISTIVE_TECHNOLOGY',
			],
			[
				'item_name' 	=> 'Technology AND Other Device Positioning Systems',
				'item_number'	=> '05_242400111_0103_1_2',
				'category_name' => 'ASSISTIVE_TECHNOLOGY',
			],
			[
				'item_name' 	=> 'Delivery - Personal care and safety AT',
				'item_number'	=> '05_711000080_0103_1_2',
				'category_name' => 'CONSUMABLES',
			],
			[
				'item_name' 	=> 'HM - Bathroom/Toilet - No structural work',
				'item_number'	=> '06_182400321_0111_2_2',
				'category_name' => 'HOME_MODIFICATIONS',
			],
			[
				'item_name' 	=> 'HM - Access -  Entrance/Ramp',
				'item_number'	=> '06_183018403_0111_2_2',
				'category_name' => 'HOME_MODIFICATIONS',
			]
		];

		foreach ($data as $value) {
			$items = new ProductCategoryItems();
			$items->item_number 	= $value['item_number'];
			$items->item_name 		= $value['item_name'];
			$items->category_name 	= $value['category_name'];
			$items->save();
		}
    }
}
