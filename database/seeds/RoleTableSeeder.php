<?php

use Illuminate\Database\Seeder;
use App\Role;
class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new Role();
        $role->name = 'directivo';
        $role->description = 'Directivo o preceptor';
        $role->save();        

        $role = new Role();
        $role->name = 'docente';
        $role->description = 'Docente';
        $role->save();

        $role = new Role();
        $role->name = 'estudiante';
        $role->description = 'Estudiante';
        $role->save();

    }
}
