<?php

class PostViewSeeder extends Seeder {
    
    public function run() {

        DB::table(PostView::TABLE_NAME)->delete();

        $postView = new PostView();
        $postView->view = 'lost_and_found';
        $postView->title = "Lost &amp; Found";
        $postView->save();
    }

}
