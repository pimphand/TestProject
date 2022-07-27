<?php

namespace App\Imports;

use App\Models\Group;
use App\Models\Member;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;


class MembersImport implements ToModel, WithHeadingRow, WithChunkReading
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $group = Group::updateOrCreate([
            'city' => $row['group']
        ], [
            "name" => $row['group']
        ]);
        // member_id,group,nama,alamat,hp,email
        return  Member::updateOrCreate([
            "code" => $row['member_id'],
        ], [
            'name' => $row['nama'],
            'group_id' => $group->id,
            'address' => $row['alamat'],
            'phone' => $row['hp'],
            'email' => $row['email'],
        ]);
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
