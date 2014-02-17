<?php

class PostViewSeeder extends Seeder {
    
    public function run() {

        DB::table(PostView::TABLE_NAME)->delete();

        $postViews = array(
            array(
                'post_view_id' => 0,
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
