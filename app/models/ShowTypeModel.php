<?php
    namespace App\Models;
    use App\Models\AbstractModel;


class ShowTypeModel extends AbstractModel{

    public int $id;
    public string $name;
    public string $thumbnail;

    protected function getTable(): string
    {
        return 'show_types';
    }

}
 ?>