<?php

class CharityCategorySeeder extends Seeder {

    private $categories = array(
        "Animals", "Children"
    );

    public function run() {

        foreach ($this->categories as $cat) {
            $category = new CharityCategory();
            $category->title = $cat;
            $category->save();
        }
    }

}
