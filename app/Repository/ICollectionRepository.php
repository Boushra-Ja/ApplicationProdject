<?php

namespace App\Repository;

interface ICollectionRepository
{

    public function I_all_file_to_reserve();

    public function I_all_file_not_in_collection($collection_id);

    public function I_show_all_users_in_collection($collection_id);

    public function I_show_all_users_not_in_collection($collection_id);

    public function I_show_my_collection_file($collection_id);

    public function I_show_all_collection();

    public function I_show_my_collection();


}
