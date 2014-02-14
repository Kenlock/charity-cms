<?php

class ModelTest extends TestCase {

    public function testCreateCharityValidation() {

        #$data = array(
        #    'charity_name' => 'My Charity',
        #    'charity_description'   => 'This is my description'
        #);

        #$validator = Charity::validate($data);
        #echo $validator->errors();
        //$this->assertTrue($validator->passes());
        
    }

    public function testCharityCategoryList() {
        #$category = new CharityCategory();
        #$category->title = "Animals";
        #$category->save();

        //var_dump(CharityCategory::getTitles());
        //var_dump(CharityCategory::getCategoryId('Animals')->charity_category_id);
    }

    public function testAidan() {
        #$value  = true;
        #$this->assertTrue($value);
    }

    public function testMakePermission() {
        $user = User::find(1);
        $charity = Charity::find(1);
        $page = null;
        $level = 1;
        $permission = Permission::make($user, $charity, $page, $level);
        $permission->save();
        dd(Permission::where('user_id', $user->user_id)->get());
    }

}
