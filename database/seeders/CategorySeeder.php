<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('categories')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $mainCategories = [
            'Electronics',
            'Vehicles',
            'Real Estate',
            'Home and Furniture',
            'Fashion',
            'Health and Beauty',
            'Sports and Fitness',
            'Babies and Kids',
            'Food and Agriculture',
//            'Services',
//            'Jobs',
            'Pets',
            'Industrial and Equipment',
            'Art and Collectibles',
            'Education and Training'
        ];

        foreach ($mainCategories as $cat) {
            Category::updateOrCreate(
                ['slug' => Str::slug($cat)],
                ['name' => $cat, 'parent_id' => null]
            );
        }

//Electronics
        $electronics = Category::where('slug', Str::slug('Electronics'))->first();
        $electronicsSubs = [
            'Phones and Tablets',
            'Printers & Scanners',
            'Phone Accessories',
            'Computers & Laptops',
            'Computer Accessories',
            'Monitors',
            'TVs & Audio',
            'Cameras & Photography',
            'Gaming Consoles & Accessories',
            'Smart Home Devices',
            'Wearables',
            'Storage Devices',
            'Networking Equipment',
            'Drones & Robotics',
            'Solar & Renewable Energy',
        ];
        foreach ($electronicsSubs as $sub) {
            Category::updateOrCreate(
                ['slug' => Str::slug($sub)],
                ['name' => $sub, 'parent_id' => $electronics->id]
            );
        }
        // Define sub-subcategories
        $subSubs = [
            'Phones and Tablets' => ['Smartphones', 'Feature Phones', 'Tablets', 'Phablets'],
            'Phone Accessories' => ['Chargers', 'Cables', 'Earphones', 'Power Banks', 'Phone Cases', 'Screen Protectors'],
            'Computers & Laptops' => ['Laptops', 'Desktops', 'All-in-One PCs', 'Macbooks', 'Gaming PCs'],
            'Computer Accessories' => ['Keyboards', 'Mouse', 'External Hard Drives', 'USB Drives', 'Webcams', 'Headsets'],
            'Printers & Scanners' => ['Inkjet Printers', 'Laser Printers', '3D Printers', 'Scanners', 'Multifunction Devices'],
            'Monitors' => ['LED Monitors', 'LCD Monitors', 'Curved Monitors', 'Gaming Monitors', 'Touchscreen Monitors'],
            'Storage Devices' => ['HDD', 'SSD', 'External Drives', 'Flash Drives', 'Memory Cards'],
            'Networking Equipment' => ['Routers', 'Modems', 'Switches', 'Range Extenders', 'Access Points'],
            'TVs & Audio' => ['LED TVs', 'Smart TVs', 'Home Theater Systems', 'Speakers', 'Soundbars', 'Projectors'],
            'Cameras & Photography' => ['DSLR Cameras', 'Mirrorless Cameras', 'Action Cameras', 'Lenses', 'Tripods', 'Camera Accessories'],
            'Gaming Consoles & Accessories' => ['PlayStation', 'Xbox', 'Nintendo', 'Controllers', 'Gaming Headsets'],
            'Smart Home Devices' => ['Smart Lights', 'Smart Plugs', 'Smart Thermostats', 'Smart Security Cameras', 'Smart Locks'],
            'Wearables' => ['Smartwatches', 'Fitness Trackers', 'VR Headsets', 'Smart Glasses'],
            'Solar & Renewable Energy' => ['Solar Panels', 'Solar Lights', 'Solar Chargers', 'Solar Batteries', 'inverters'],
            'Drones & Robotics' => ['Drones', 'Drone Accessories', 'Robotic Kits', 'Robot Vacuum', 'Educational Robots']
        ];

// Create each sub-subcategory
        foreach ($subSubs as $parentName => $children) {
            $parent = Category::where('slug', Str::slug($parentName))->first();
            if ($parent) {
                foreach ($children as $child) {
                    Category::updateOrCreate(
                        ['slug' => Str::slug($child)],
                        ['name' => $child, 'parent_id' => $parent->id]
                    );
                }
            }
        }

// Vehicles
        $vehicles = Category::where('slug', Str::slug('Vehicles'))->first();
        $vehiclesSubs = [
            'Cars',
            'Motorcycles & Scooters',
            'Trucks & Commercial Vehicles',
            'Bicycles',
            'Vehicle Parts & Accessories',
            'Car Audio & Electronics',
            'Boats & Watercraft',
            'Vehicle Rentals & Leasing'
        ];
        foreach ($vehiclesSubs as $sub) {
            Category::updateOrCreate(
                ['slug' => Str::slug($sub)],
                ['name' => $sub, 'parent_id' => $vehicles->id]
            );
        }

// Optional: further subcategories under Cars
        $cars = Category::where('slug', Str::slug('Cars'))->first();
        $carsSubs = ['Sedans', 'SUVs', 'Hatchbacks', 'Convertibles', 'Luxury Cars'];
        foreach ($carsSubs as $sub) {
            Category::updateOrCreate(
                ['slug' => Str::slug($sub)],
                ['name' => $sub, 'parent_id' => $cars->id]
            );
        }

// Optional: further subcategories under Motorcycles & Scooters
        $motorcycles = Category::where('slug', Str::slug('Motorcycles & Scooters'))->first();
        $motorcyclesSubs = ['Scooters', 'Motorbikes', 'Electric Motorcycles'];
        foreach ($motorcyclesSubs as $sub) {
            Category::updateOrCreate(
                ['slug' => Str::slug($sub)],
                ['name' => $sub, 'parent_id' => $motorcycles->id]
            );
        }

// Optional: further subcategories under Trucks & Commercial Vehicles
        $trucks = Category::where('slug', Str::slug('Trucks & Commercial Vehicles'))->first();
        $trucksSubs = ['Pickup Trucks', 'Lorries', 'Vans', 'Trailers', 'Commercial Buses'];
        foreach ($trucksSubs as $sub) {
            Category::updateOrCreate(
                ['slug' => Str::slug($sub)],
                ['name' => $sub, 'parent_id' => $trucks->id]
            );
        }

// Optional: further subcategories under Bicycles
        $bicycles = Category::where('slug', Str::slug('Bicycles'))->first();
        $bicyclesSubs = ['Mountain Bikes', 'Road Bikes', 'Hybrid Bikes', 'Electric Bikes', 'Kids Bikes'];
        foreach ($bicyclesSubs as $sub) {
            Category::updateOrCreate(
                ['slug' => Str::slug($sub)],
                ['name' => $sub, 'parent_id' => $bicycles->id]
            );
        }

// Optional: further subcategories under Vehicle Parts & Accessories
        $vehicleParts = Category::where('slug', Str::slug('Vehicle Parts & Accessories'))->first();
        $vehiclePartsSubs = ['Engine Parts', 'Brakes & Suspension', 'Car Tires', 'Lights & Indicators', 'Mirrors'];
        foreach ($vehiclePartsSubs as $sub) {
            Category::updateOrCreate(
                ['slug' => Str::slug($sub)],
                ['name' => $sub, 'parent_id' => $vehicleParts->id]
            );
        }

// Optional: further subcategories under Car Audio & Electronics
        $carAudio = Category::where('slug', Str::slug('Car Audio & Electronics'))->first();
        $carAudioSubs = ['Speakers', 'Amplifiers', 'Stereos & Head Units', 'Subwoofers', 'Car Alarms'];
        foreach ($carAudioSubs as $sub) {
            Category::updateOrCreate(
                ['slug' => Str::slug($sub)],
                ['name' => $sub, 'parent_id' => $carAudio->id]
            );
        }

// Optional: further subcategories under Boats & Watercraft
        $boats = Category::where('slug', Str::slug('Boats & Watercraft'))->first();
        $boatsSubs = ['Motorboats', 'Sailboats', 'Yachts', 'Jet Skis', 'Kayaks & Canoes'];
        foreach ($boatsSubs as $sub) {
            Category::updateOrCreate(
                ['slug' => Str::slug($sub)],
                ['name' => $sub, 'parent_id' => $boats->id]
            );
        }

// Optional: further subcategories under Vehicle Rentals & Leasing
        $rentals = Category::where('slug', Str::slug('Vehicle Rentals & Leasing'))->first();
        $rentalsSubs = ['Car Rentals', 'Motorbike Rentals', 'Truck Rentals', 'Boat Rentals'];
        foreach ($rentalsSubs as $sub) {
            Category::updateOrCreate(
                ['slug' => Str::slug($sub)],
                ['name' => $sub, 'parent_id' => $rentals->id]
            );
        }


//Real estate
        $realEstate = Category::where('slug', Str::slug('Real Estate'))->first();
        $realEstateSubs = [
            'Residential Properties',
            'Commercial Properties',
            'Land',
            'Rentals',
            'Real Estate Services'
        ];
        foreach ($realEstateSubs as $sub) {
            Category::updateOrCreate(
                ['slug' => Str::slug($sub)],
                ['name' => $sub, 'parent_id' => $realEstate->id]
            );
        }
// Optional: further subcategories under Residential Properties
        $residential = Category::where('slug', Str::slug('Residential Properties'))->first();
        $residentialSubs = ['Apartments', 'Houses', 'Villas', 'Condominiums'];
        foreach ($residentialSubs as $sub) {
            Category::updateOrCreate(
                ['slug' => Str::slug($sub)],
                ['name' => $sub, 'parent_id' => $residential->id]
            );
        }

// Optional: further subcategories under Commercial Properties
        $commercial = Category::where('slug', Str::slug('Commercial Properties'))->first();
        $commercialSubs = ['Office Spaces', 'Shops & Retail', 'Warehouses', 'Industrial Buildings'];
        foreach ($commercialSubs as $sub) {
            Category::updateOrCreate(
                ['slug' => Str::slug($sub)],
                ['name' => $sub, 'parent_id' => $commercial->id]
            );
        }
// Optional: further subcategories under Land
        $land = Category::where('slug', Str::slug('Land'))->first();
        $landSubs = ['Plots', 'Farmland', 'Industrial Land'];
        foreach ($landSubs as $sub) {
            Category::updateOrCreate(
                ['slug' => Str::slug($sub)],
                ['name' => $sub, 'parent_id' => $land->id]
            );
        }
//Optional: further subcategories under Rentals
        $rentals = Category::where('slug', Str::slug('Rentals'))->first();
        $rentalSubs = ['Short-term Rentals', 'Long-term Rentals'];
        foreach ($rentalSubs as $sub) {
            Category::updateOrCreate(
                ['slug' => Str::slug($sub)],
                ['name' => $sub, 'parent_id' => $rentals->id]
            );
        }
// Optional: further subcategories under Real Estate Services
        $services = Category::where('slug', Str::slug('Real Estate Services'))->first();
        $servicesSubs = ['Agencies & Brokers', 'Property Management', 'Valuation & Appraisal'];
        foreach ($servicesSubs as $sub) {
            Category::updateOrCreate(
                ['slug' => Str::slug($sub)],
                ['name' => $sub, 'parent_id' => $services->id]
            );
        }

//Home and funitures
        $homeFurniture = Category::where('slug', Str::slug('Home and Furniture'))->first();
        $homeSubs = [
            'Furniture',
            'Home Appliances',
            'Home Décor',
            'Garden & Outdoor',
            'Tools & DIY'
        ];
        foreach ($homeSubs as $sub) {
            Category::updateOrCreate(
                ['slug' => Str::slug($sub)],
                ['name' => $sub, 'parent_id' => $homeFurniture->id]
            );
        }
        // Furniture subcategories
        $furniture = Category::where('slug', Str::slug('Furniture'))->first();
        $furnitureSubs = ['Sofas & Couches', 'Beds & Mattresses', 'Tables & Chairs', 'Cabinets & Storage'];
        foreach ($furnitureSubs as $sub) {
            Category::updateOrCreate(
                ['slug' => Str::slug($sub)],
                ['name' => $sub, 'parent_id' => $furniture->id]
            );
        }
        // Home Appliances subcategories
        $appliances = Category::where('slug', Str::slug('Home Appliances'))->first();
        $applianceSubs = ['Kitchen Appliances', 'Laundry Appliances', 'Air Conditioners & Heaters'];
        foreach ($applianceSubs as $sub) {
            Category::updateOrCreate(
                ['slug' => Str::slug($sub)],
                ['name' => $sub, 'parent_id' => $appliances->id]
            );
        }

        // Home Décor subcategories
        $decor = Category::where('slug', Str::slug('Home Décor'))->first();
        $decorSubs = ['Rugs & Carpets', 'Curtains & Blinds', 'Wall Art & Frames', 'Lighting'];
        foreach ($decorSubs as $sub) {
            Category::updateOrCreate(
                ['slug' => Str::slug($sub)],
                ['name' => $sub, 'parent_id' => $decor->id]
            );
        }

        // Garden & Outdoor subcategories
        $garden = Category::where('slug', Str::slug('Garden & Outdoor'))->first();
        $gardenSubs = ['Garden Furniture', 'Tools & Equipment', 'Plants & Gardening Supplies'];
        foreach ($gardenSubs as $sub) {
            Category::updateOrCreate(
                ['slug' => Str::slug($sub)],
                ['name' => $sub, 'parent_id' => $garden->id]
            );
        }

        // Tools & DIY subcategories
        $tools = Category::where('slug', Str::slug('Tools & DIY'))->first();
        $toolsSubs = ['Hand Tools', 'Power Tools', 'Home Improvement Materials'];
        foreach ($toolsSubs as $sub) {
            Category::updateOrCreate(
                ['slug' => Str::slug($sub)],
                ['name' => $sub, 'parent_id' => $tools->id]
            );
        }


//    Fashion
        $fashion = Category::where('slug', Str::slug('Fashion'))->first();
        $fashionSubs = [
            'Clothing',
            'Shoes',
            'Bags',
            'Jewelry',
            'Accessories'
        ];
        foreach ($fashionSubs as $sub) {
            Category::updateOrCreate(
                ['slug' => Str::slug($sub)],
                ['name' => $sub, 'parent_id' => $fashion->id]
            );
        }

// Optional: Clothing subcategories
        $clothing = Category::where('slug', Str::slug('Clothing'))->first();
        $clothingSubs = ['Men', 'Women', 'Kids'];
        foreach ($clothingSubs as $sub) {
            Category::updateOrCreate(
                ['slug' => Str::slug($sub)],
                ['name' => $sub, 'parent_id' => $clothing->id]
            );
        }

// Optional: Shoes subcategories
        $shoes = Category::where('slug', Str::slug('Shoes'))->first();
        $shoesSubs = ['Men', 'Women', 'Kids'];
        foreach ($shoesSubs as $sub) {
            Category::updateOrCreate(
                ['slug' => Str::slug($sub)],
                ['name' => $sub, 'parent_id' => $shoes->id]
            );
        }

//        Health and Beauty
        $healthBeauty = Category::where('slug', Str::slug('Health and Beauty'))->first();
        $healthBeautySubs = [
            'Personal Care',
            'Skincare',
            'Hair Care',
            'Makeup & Cosmetics',
            'Wellness & Fitness',
            'Health Supplies'
        ];
        foreach ($healthBeautySubs as $sub) {
            Category::updateOrCreate(
                ['slug' => Str::slug($sub)],
                ['name' => $sub, 'parent_id' => $healthBeauty->id]
            );
        }
        // Optional: Personal Care subcategories
        $personalCare = Category::where('slug', Str::slug('Personal Care'))->first();
        $personalCareSubs = ['Soap & Body Wash', 'Deodorants', 'Oral Care'];
        foreach ($personalCareSubs as $sub) {
            Category::updateOrCreate(
                ['slug' => Str::slug($sub)],
                ['name' => $sub, 'parent_id' => $personalCare->id]
            );
        }
        // Optional: Skincare subcategories
        $skincare = Category::where('slug', Str::slug('Skincare'))->first();
        $skincareSubs = ['Face', 'Body', 'Sun Care'];
        foreach ($skincareSubs as $sub) {
            Category::updateOrCreate(
                ['slug' => Str::slug($sub)],
                ['name' => $sub, 'parent_id' => $skincare->id]
            );
        }


//        Sport and fitness
        $sportsFitness = Category::where('slug', Str::slug('Sports and Fitness'))->first();
        $sportsFitnessSubs = [
            'Sports Equipment',
            'Fitness Equipment',
            'Apparel & Footwear',
            'Outdoor & Adventure',
            'Supplements & Nutrition'
        ];
        foreach ($sportsFitnessSubs as $sub) {
            Category::updateOrCreate(
                ['slug' => Str::slug($sub)],
                ['name' => $sub, 'parent_id' => $sportsFitness->id]
            );
        }
        // Optional: Sports Equipment subcategories
        $sportsEquipment = Category::where('slug', Str::slug('Sports Equipment'))->first();
        $sportsEquipmentSubs = ['Football', 'Basketball', 'Tennis', 'Cycling'];
        foreach ($sportsEquipmentSubs as $sub) {
            Category::updateOrCreate(
                ['slug' => Str::slug($sub)],
                ['name' => $sub, 'parent_id' => $sportsEquipment->id]
            );
        }
        // Optional: Fitness Equipment subcategories
        $fitnessEquipment = Category::where('slug', Str::slug('Fitness Equipment'))->first();
        $fitnessEquipmentSubs = ['Treadmills', 'Dumbbells', 'Exercise Bikes', 'Yoga & Pilates'];
        foreach ($fitnessEquipmentSubs as $sub) {
            Category::updateOrCreate(
                ['slug' => Str::slug($sub)],
                ['name' => $sub, 'parent_id' => $fitnessEquipment->id]
            );
        }

//        Toys and kids
        $babiesKids = Category::where('slug', Str::slug('Babies and Kids'))->first();
        $babiesKidsSubs = [
            'Kids Clothing',
            'Toys & Games',
            'Gear & Accessories',
            'Nursery & Furniture',
            'Health & Safety'
        ];
        foreach ($babiesKidsSubs as $sub) {
            Category::updateOrCreate(
                ['slug' => Str::slug($sub)],
                ['name' => $sub, 'parent_id' => $babiesKids->id]
            );
        }
        // Optional: Clothing subcategories
        $clothing = Category::where('slug', Str::slug('Kids Clothing'))->first();
        $clothingSubs = ['Boys', 'Girls', 'Unisex'];
        foreach ($clothingSubs as $sub) {
            Category::updateOrCreate(
                ['slug' => Str::slug($sub)],
                ['name' => $sub, 'parent_id' => $clothing->id]
            );
        }

        // Optional: Toys & Games subcategories
        $toys = Category::where('slug', Str::slug('Toys & Games'))->first();
        $toysSubs = ['Educational', 'Action Figures', 'Puzzles', 'Outdoor Play'];
        foreach ($toysSubs as $sub) {
            Category::updateOrCreate(
                ['slug' => Str::slug($sub)],
                ['name' => $sub, 'parent_id' => $toys->id]
            );
        }

//    Food and Agro products
        $foodAgri = Category::where('slug', Str::slug('Food and Agriculture'))->first();
        $foodAgriSubs = [
            'Groceries',
            'Fresh Produce',
            'Packaged Food',
            'Beverages',
            'Restaurants & Catering',
            'Farm Supplies'
        ];
        foreach ($foodAgriSubs as $sub) {
            Category::updateOrCreate(
                ['slug' => Str::slug($sub)],
                ['name' => $sub, 'parent_id' => $foodAgri->id]
            );
        }
        // Optional: Groceries subcategories
        $groceries = Category::where('slug', Str::slug('Groceries'))->first();
        $groceriesSubs = ['Dry Goods', 'Dairy', 'Bakery'];
        foreach ($groceriesSubs as $sub) {
            Category::updateOrCreate(
                ['slug' => Str::slug($sub)],
                ['name' => $sub, 'parent_id' => $groceries->id]
            );
        }

        // Optional: Fresh Produce subcategories
        $produce = Category::where('slug', Str::slug('Fresh Produce'))->first();
        $produceSubs = ['Fruits', 'Vegetables', 'Herbs', 'Meat & Poultry'];
        foreach ($produceSubs as $sub) {
            Category::updateOrCreate(
                ['slug' => Str::slug($sub)],
                ['name' => $sub, 'parent_id' => $produce->id]
            );
        }

        // Optional: Beverages subcategories
        $beverages = Category::where('slug', Str::slug('Beverages'))->first();
        $beveragesSubs = ['Soft Drinks', 'Juices', 'Alcoholic Drinks', 'Tea & Coffee'];
        foreach ($beveragesSubs as $sub) {
            Category::updateOrCreate(
                ['slug' => Str::slug($sub)],
                ['name' => $sub, 'parent_id' => $beverages->id]
            );
        }

//        Pets
        $pets = Category::where('slug', Str::slug('Pets'))->first();
        $petsSubs = [
            'Animals',
            'Pet Food',
            'Pet Accessories',
            'Pet Health & Care',
            'Pet Services'
        ];
        foreach ($petsSubs as $sub) {
            Category::updateOrCreate(
                ['slug' => Str::slug($sub)],
                ['name' => $sub, 'parent_id' => $pets->id]
            );
        }
        // Optional: Animals subcategories
        $animals = Category::where('slug', Str::slug('Animals'))->first();
        $animalsSubs = ['Dogs', 'Cats', 'Birds', 'Fish', 'Small Mammals'];
        foreach ($animalsSubs as $sub) {
            Category::updateOrCreate(
                ['slug' => Str::slug($sub)],
                ['name' => $sub, 'parent_id' => $animals->id]
            );
        }
        // Optional: Pet Food subcategories
        $petFood = Category::where('slug', Str::slug('Pet Food'))->first();
        $petFoodSubs = ['Dog Food', 'Cat Food', 'Bird Food', 'Fish Food'];
        foreach ($petFoodSubs as $sub) {
            Category::updateOrCreate(
                ['slug' => Str::slug($sub)],
                ['name' => $sub, 'parent_id' => $petFood->id]
            );
        }

//        Industrial and Equipments
        $industrial = Category::where('slug', Str::slug('Industrial and Equipment'))->first();
        $industrialSubs = [
            'Machinery',
            'Tools & Equipment',
            'Safety & Protective Gear',
            'Industrial Supplies',
            'Construction Equipment'
        ];
        foreach ($industrialSubs as $sub) {
            Category::updateOrCreate(
                ['slug' => Str::slug($sub)],
                ['name' => $sub, 'parent_id' => $industrial->id]
            );
        }

        // Optional: Machinery subcategories
        $machinery = Category::where('slug', Str::slug('Machinery'))->first();
        $machinerySubs = ['Generators', 'Engines', 'Agricultural Machinery'];
        foreach ($machinerySubs as $sub) {
            Category::updateOrCreate(
                ['slug' => Str::slug($sub)],
                ['name' => $sub, 'parent_id' => $machinery->id]
            );
        }

        // Optional: Tools & Equipment subcategories
        $tools = Category::where('slug', Str::slug('Tools & Equipment'))->first();
        $toolsSubs = ['Hand Tools', 'Power Tools', 'Measuring Tools'];
        foreach ($toolsSubs as $sub) {
            Category::updateOrCreate(
                ['slug' => Str::slug($sub)],
                ['name' => $sub, 'parent_id' => $tools->id]
            );
        }

//        Art and collectibles
        $artCollectibles = Category::where('slug', Str::slug('Art and Collectibles'))->first();
        $artCollectiblesSubs = [
            'Artwork',
            'Antiques',
            'Memorabilia',
            'Crafts',
            'Collectible Items'
        ];
        foreach ($artCollectiblesSubs as $sub) {
            Category::updateOrCreate(
                ['slug' => Str::slug($sub)],
                ['name' => $sub, 'parent_id' => $artCollectibles->id]
            );
        }

        // Optional: Artwork subcategories
        $artwork = Category::where('slug', Str::slug('Artwork'))->first();
        $artworkSubs = ['Paintings', 'Sculptures', 'Prints'];
        foreach ($artworkSubs as $sub) {
            Category::updateOrCreate(
                ['slug' => Str::slug($sub)],
                ['name' => $sub, 'parent_id' => $artwork->id]
            );
        }

        // Optional: Collectible Items subcategories
        $collectibles = Category::where('slug', Str::slug('Collectible Items'))->first();
        $collectiblesSubs = ['Coins', 'Stamps', 'Cards'];
        foreach ($collectiblesSubs as $sub) {
            Category::updateOrCreate(
                ['slug' => Str::slug($sub)],
                ['name' => $sub, 'parent_id' => $collectibles->id]
            );
        }

//Education and training
        $education = Category::where('slug', Str::slug('Education and Training'))->first();
        $educationSubs = [
            'Schools & Institutions',
            'Online Courses',
            'Tutoring & Lessons',
            'Professional Training',
            'Educational Materials'
        ];
        foreach ($educationSubs as $sub) {
            Category::updateOrCreate(
                ['slug' => Str::slug($sub)],
                ['name' => $sub, 'parent_id' => $education->id]
            );
        }
        // Optional: Schools & Institutions subcategories
        $schools = Category::where('slug', Str::slug('Schools & Institutions'))->first();
        $schoolsSubs = ['Primary', 'Secondary', 'Tertiary'];
        foreach ($schoolsSubs as $sub) {
            Category::updateOrCreate(
                ['slug' => Str::slug($sub)],
                ['name' => $sub, 'parent_id' => $schools->id]
            );
        }
        // Optional: Tutoring & Lessons subcategories
        $tutoring = Category::where('slug', Str::slug('Tutoring & Lessons'))->first();
        $tutoringSubs = ['Language', 'Music', 'Coding', 'Arts'];
        foreach ($tutoringSubs as $sub) {
            Category::updateOrCreate(
                ['slug' => Str::slug($sub)],
                ['name' => $sub, 'parent_id' => $tutoring->id]
            );
        }
    }

}
