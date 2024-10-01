<?php

namespace App\Models;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
   
    // Koneksi ke database utama
    protected $connection = 'mysql';
    protected $table = 'tickets';
    // Kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'no_tiket', 'nik', 'no_inventaris', 'tanggal', 'prioritas',
        'status', 'deadline', 'judul', 'deskripsi', 'upload', 'departemen',
        'nik_teknisi', 'no_hp', 'jenis_permintaan'
    ];
    
    protected $dates = ['deadline','created_at', 'updated_at', 'response_time'];
    protected $casts = [
        'response_time' => 'datetime',
    ];
    
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'nik', 'nik');
    }

    public function inventaris()
    {
        return $this->belongsTo(Inventaris::class, 'no_inventaris', 'no_inventaris');
    }

    public function departemen()
    {
    return $this->belongsTo(Departemen::class, 'departemen', 'dep_id');
    }

    public function teknisi()
    {
        return $this->belongsTo(Pegawai::class, 'nik_teknisi', 'nik');
    }

    public function jenisPermintaan()
    {
        return $this->belongsTo(JenisPermintaan::class, 'jenis_permintaan', 'id');
    }

    protected static function boot()
    {
        parent::boot();

        // Ketika membuat tiket baru, generate nomor tiket otomatis
        static::creating(function ($ticket) {
            $today = Carbon::now()->format('Y/m/d');
            $lastTicket = Ticket::whereDate('created_at', Carbon::today())
                ->orderBy('id', 'desc')
                ->first();

            $newNumber = $lastTicket ? intval(substr($lastTicket->no_tiket, -3)) + 1 : 1;
            $ticket->no_tiket = $today . '/' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
        });

        // Hapus file jika tiket dihapus
        static::deleting(function ($ticket) {
            if ($ticket->upload && file_exists(public_path('uploads/' . $ticket->upload))) {
                unlink(public_path('uploads/' . $ticket->upload));
            }
        });
    }
    
    public function komentar()
    {
        return $this->hasMany(Komentar::class, 'ticket_id');
    }
    // Relasi ke respon kerja
    public function responKerja()
    {
        return $this->hasMany(ResponKerja::class, 'ticket_id');
    }

    // Relasi ke riwayat status
    public function statusHistory()
    {
        return $this->hasMany(TicketStatusHistory::class, 'ticket_id');
    }

    // Relasi ke teknisi yang menangani
    public function teknisiMenangani()
    {
        return $this->hasMany(TicketTeknisi::class, 'ticket_id');
    }

    // Accessor untuk response_time
public function getResponseTimeAttribute()
{
    // Ambil respon pertama yang ada
    $responPertama = $this->responKerja->sortBy('created_at')->first();

    // Pastikan respon pertama dan created_at tiket ada
    if ($responPertama && $this->created_at) {
        return $responPertama->created_at->diffInMinutes($this->created_at);
    }

    return null; // Kembalikan null jika tidak ada respon atau tiket tidak memiliki created_at
}

// Accessor untuk completion_time
public function getCompletionTimeAttribute()
{
    // Ambil respon terakhir yang statusnya selesai
    $responSelesai = $this->responKerja->where('status_akhir', 'selesai')->sortByDesc('created_at')->first();

    // Pastikan respon selesai dan created_at tiket ada
    if ($responSelesai && $this->created_at) {
        return $responSelesai->created_at->diffInMinutes($this->created_at);
    }

    return null; // Kembalikan null jika tidak ada respon selesai atau tiket tidak memiliki created_at
}

}