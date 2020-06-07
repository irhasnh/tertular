<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pasien extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class,'kelurahan_id');
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class,'kecamatan_id');
    }

    public function kota()
    {
        return $this->belongsTo(Kota::class,'kota_id');
    }

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class,'provinsi_id');
    }

    public function lokasi_kelurahan()
    {
        return $this->belongsTo(Kelurahan::class,'kelurahan_id');
    }

    public function lokasi_kecamatan()
    {
        return $this->belongsTo(Kecamatan::class,'kecamatan_id');
    }

    public function lokasi_kota()
    {
        return $this->belongsTo(Kota::class,'kota_id');
    }

    public function lokasi_provinsi()
    {
        return $this->belongsTo(Provinsi::class,'provinsi_id');
    }

    public function klaster()
    {
        return $this->belongsTo(Klaster::class);
    }

    public function interaksis()
    {
        return $this->hasMany(Interaksi::class,'pasien_id');
    }

    public function getInteraksiGeojsonAttribute()
    {
        $interaksis = $this->interaksis()->get();
        $data = [
            "type"=>"FeatureCollection",
            "features"=>[]
        ];
        foreach ($interaksis as $interaksi) {
            if($interaksi->lokasi != null){
                $koordinat = explode(",",$interaksi->koordinat_lokasi);
                $data['features'][] = [
                    "type"=>"Feature",
                    "geometry"=>[
                        "type"=>"Point",
                        "coordinates"=>[(double)$koordinat[1],(double)$koordinat[0]]
                    ],
                    "properties"=>[
                        "lokasi"=>$interaksi->lokasi,
                        "keterangan"=>$interaksi->keterangan
                    ]
                ];
            }
            
        }

        return $data;
    }
}
