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
        $category = new CharityCategory();
        $category->title = "Animals";
        $category->save();

        //var_dump(CharityCategory::getTitles());
        //var_dump(CharityCategory::getCategoryId('Animals')->charity_category_id);
    }

    public function testAidan() {
        $value  = true;
        $this->assertTrue($value);
    }

}
