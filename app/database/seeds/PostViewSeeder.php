<?php

class PostViewSeeder extends Seeder {
    
    public function run() {

        DB::table(PostView::TABLE_NAME)->delete();

        $postViews = array(
            array(
                'view' => 'announcement',
                'title' => 'Announcement'
            ),
            array(
                'view' => 'lost_and_found',
                'title' => 'Lost &amp; Found'
            ),
            array(
                'view' => 'adoption',
                'title' => 'Adopt and Animal'
            ),
        );

        PostView::insert($postViews);

    }

}
