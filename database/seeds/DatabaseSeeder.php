<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        $this->call(RolesSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(PermissionRoleSeeder::class);
        $this->call(AssignedRoleSeeder::class);
        $this->call(UsersSeeder::class);
        //$this->call(ProductSeeder::class);
        //$this->call(CategorySeeder::class);
        //$this->call(OptionSeeder::class);    
    }
}
/**
* 
*/
class OptionSeeder extends Seeder
{
    
    public function run()
    {
        DB::table('option')->insert([
            ['option_name'=>'trứng','option_price'=>5000,'product_id'=>20],
            ['option_name'=>'xúc xích','option_price'=>10000,'product_id'=>20],
            ['option_name'=>'đùi gà','option_price'=>30000,'product_id'=>21],
            ['option_name'=>'xúc xích','option_price'=>10000,'product_id'=>22],            
        ]);
    }
}
/**
* 
*/
class ProductSeeder extends Seeder
{
    
    public function run()
    {
        DB::table('product')->insert([
            ['product_name'=>'cơm gà','product_image'=>'images/Order-Food-1.png','product_desc'=>'','product_price'=>50000,'category_id'=>6],
            ['product_name'=>'xôi gà','product_image'=>'images/Order-Food-2.png','product_desc'=>'','product_price'=>50000,'category_id'=>7],
            ['product_name'=>'bún gà','product_image'=>'images/Order-Food-3.png','product_desc'=>'','product_price'=>50000,'category_id'=>8],
            ['product_name'=>'phở gà','product_image'=>'images/Order-Food-2.png','product_desc'=>'','product_price'=>50000,'category_id'=>9],
            ['product_name'=>'mì gà','product_image'=>'images/Order-Food-1.png','product_desc'=>'','product_price'=>50000,'category_id'=>10],
            ['product_name'=>'bánh mì gà','product_image'=>'images/Order-Food-3.png','product_desc'=>'','product_price'=>50000,'category_id'=>11],

            ['product_name'=>'thức ăn nhanh','product_image'=>'images/Order-Snack-1.png','product_desc'=>'','product_price'=>10000,'category_id'=>12],
            ['product_name'=>'snack','product_image'=>'images/Order-Snack-2.png','product_desc'=>'','product_price'=>10000,'category_id'=>13],
            ['product_name'=>'bánh','product_image'=>'images/Order-Snack-3.png','product_desc'=>'','product_price'=>10000,'category_id'=>14],
            ['product_name'=>'kẹo','product_image'=>'images/Order-Snack-2.png','product_desc'=>'','product_price'=>10000,'category_id'=>15],

            ['product_name'=>'nước ngọt','product_image'=>'images/drink-1.png','product_desc'=>'','product_price'=>15000,'category_id'=>16],
            ['product_name'=>'nước ép','product_image'=>'images/drink-2.png','product_desc'=>'','product_price'=>15000,'category_id'=>17],
            ['product_name'=>'nước khoáng','product_image'=>'images/drink-3.png','product_desc'=>'','product_price'=>15000,'category_id'=>18],

            ['product_name'=>'combo 1','product_image'=>'images/combo-1.jpg','product_desc'=>'','product_price'=>30000,'category_id'=>19],
            ['product_name'=>'combo 2','product_image'=>'images/combo-2.jpg','product_desc'=>'','product_price'=>30000,'category_id'=>20],

            ['product_name'=>'vinataba','product_image'=>'images/Order-Service-1.png','product_desc'=>'','product_price'=>30000,'category_id'=>21],
            ['product_name'=>'marlbro','product_image'=>'images/Order-Service-2.png','product_desc'=>'','product_price'=>30000,'category_id'=>21],
            ['product_name'=>'viettel 200k','product_image'=>'images/vt200.png','product_desc'=>'','product_price'=>200000,'category_id'=>22],
            ['product_name'=>'vina game 120k','product_image'=>'images/vinagame120.jpg','product_desc'=>'','product_price'=>120000,'category_id'=>23],
        ]);
    }
}
class CategorySeeder extends Seeder
{
    public function run(){
        DB::table('category')->insert([
            ['category_name'=>'đồ ăn','category_image'=>'images/menu-item-1.png','category_desc'=>'','category_id_parent'=>0],
            ['category_name'=>'đồ ăn vặt','category_image'=>'images/menu-item-2.png','category_desc'=>'','category_id_parent'=>0],
            ['category_name'=>'đồ uống','category_image'=>'images/menu-item-3.png','category_desc'=>'','category_id_parent'=>0],
            ['category_name'=>'combo','category_image'=>'images/menu-item-4.png','category_desc'=>'','category_id_parent'=>0],
            ['category_name'=>'dịch vụ','category_image'=>'images/menu-item-5.png','category_desc'=>'','category_id_parent'=>0],

            ['category_name'=>'cơm','category_image'=>'','category_desc'=>'','category_id_parent'=>1],
            ['category_name'=>'xôi','category_image'=>'','category_desc'=>'','category_id_parent'=>1],
            ['category_name'=>'bún','category_image'=>'','category_desc'=>'','category_id_parent'=>1],
            ['category_name'=>'phở','category_image'=>'','category_desc'=>'','category_id_parent'=>1],
            ['category_name'=>'mì','category_image'=>'','category_desc'=>'','category_id_parent'=>1],
            ['category_name'=>'bánh mì','category_image'=>'','category_desc'=>'','category_id_parent'=>1],

            ['category_name'=>'thức ăn nhanh','category_image'=>'','category_desc'=>'','category_id_parent'=>2],
            ['category_name'=>'snack','category_image'=>'','category_desc'=>'','category_id_parent'=>2],
            ['category_name'=>'bánh','category_image'=>'','category_desc'=>'','category_id_parent'=>2],
            ['category_name'=>'kẹo','category_image'=>'','category_desc'=>'','category_id_parent'=>2],

            ['category_name'=>'nước ngọt','category_image'=>'','category_desc'=>'','category_id_parent'=>3],
            ['category_name'=>'nước ép','category_image'=>'','category_desc'=>'','category_id_parent'=>3],
            ['category_name'=>'nước khoáng','category_image'=>'','category_desc'=>'','category_id_parent'=>3],

            ['category_name'=>'combo-1','category_image'=>'','category_desc'=>'','category_id_parent'=>4],
            ['category_name'=>'combo-2','category_image'=>'','category_desc'=>'','category_id_parent'=>4],

            ['category_name'=>'thuốc lá','category_image'=>'','category_desc'=>'','category_id_parent'=>5],
            ['category_name'=>'thẻ điện thoại','category_image'=>'','category_desc'=>'','category_id_parent'=>5],
            ['category_name'=>'thẻ game','category_image'=>'','category_desc'=>'','category_id_parent'=>5],
        ]);
    }
}
class UsersSeeder extends Seeder
{
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        DB::table('users')->insert([
            ['name'=>'admin','email'=>'admin@gmail.com','password'=>bcrypt('123456')],
            ['name'=>'admin1','email'=>'admin1@gmail.com','password'=>bcrypt('123456')],
            ['name'=>'admin2','email'=>'admin2@gmail.com','password'=>bcrypt('123456')],
            ['name'=>'admin3','email'=>'admin3@gmail.com','password'=>bcrypt('123456')],
        ]);
    }
}
/**
* 
*/
class RolesSeeder extends Seeder
{
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table(config('access.roles_table'))->insert([
              ['name' => 'Administrator','all' => true,'sort' => 1,'created_at' =>date('Y-m-d',time()) ,'updated_at' => date('Y-m-d',time())],
        ['name' => 'Executive','all' => false,'sort' => 2,'created_at' =>date('Y-m-d',time()) ,'updated_at' => date('Y-m-d',time())],
        ['name' => 'User','all' => false,'sort' => 3,'created_at' => date('Y-m-d',time()),'updated_at' => date('Y-m-d',time())],
        ]);
    }
}
class PermissionSeeder extends Seeder
{
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        DB::table(config('access.permissions_table'))->insert([
            ['name'=>'view-backend','display_name'=>'View Back End','sort'=>0, 'created_at' =>date('Y-m-d',time()) ,'updated_at' => date('Y-m-d',time())],
            ['name'=>'manager-option','display_name'=>'Quản lý option','sort'=>0, 'created_at' =>date('Y-m-d',time()) ,'updated_at' => date('Y-m-d',time())],     
        ]);
    }
}
class PermissionRoleSeeder extends Seeder
{
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        DB::table(config('access.permission_role_table'))->insert([
            ['permission_id'=>'1','role_id'=>'1'],
            ['permission_id'=>'2','role_id'=>'2'],
           
        ]);
    }
}

class AssignedRoleSeeder extends Seeder
{
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        DB::table(config('access.assigned_roles_table'))->insert([
            ['user_id'=>'1','role_id'=>'1'],
            ['user_id'=>'2','role_id'=>'2'],
           
        ]);
    }
}
