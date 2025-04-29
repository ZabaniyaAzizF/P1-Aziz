<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;

class DatabaseController extends Controller
{
    public function index(){

        return view('backup.index');
    }

    public function backup()
    {
        $dbName = env('DB_DATABASE');
        $dbUser = env('DB_USERNAME');
        $dbPass = env('DB_PASSWORD');
        $dbHost = env('DB_HOST', '127.0.0.1');
        $fileName = 'ukk2223_p1aziz' .'.sql';
        $backupPath = storage_path("app/backup/{$fileName}");
    
        // Pastikan direktori backup ada
        if (!is_dir(storage_path('app/backup'))) {
            mkdir(storage_path('app/backup'), 0755, true);
        }
    
        $mysqldumpPath = "C:\\laragon\\bin\\mysql\\mysql-8.0.30-winx64\\bin\\mysqldump";
    
        // Gunakan string escaping agar tanda petik tidak bentrok
        $command = "\"{$mysqldumpPath}\" --host={$dbHost} --user={$dbUser} --password=\"{$dbPass}\" --routines --triggers {$dbName} > \"{$backupPath}\"";
    
        $result = null;
        $output = null;
    
        exec($command, $output, $result);
    
        if ($result !== 0) {
            return back()->with('error', 'Backup gagal. Periksa konfigurasi database dan hak akses.');
        }
    
        return response()->download($backupPath)->deleteFileAfterSend(true);
    }
    

    public function restore(Request $request)
    {
        $request->validate([
            'backup_file' => 'required|mimes:sql'
        ]);
    
        $file = $request->file('backup_file');
        $path = $file->storeAs('backup', 'restore-temp.sql');
    
        $db = config('database.connections.mysql');
        $restoreFile = storage_path("app/{$path}");
    
        $mysqlPath = "C:\\laragon\\bin\\mysql\\mysql-8.0.30-winx64\\bin\\mysql";
    
        if ($db['password']) {
            $command = "\"{$mysqlPath}\" -u {$db['username']} -p\"{$db['password']}\" {$db['database']} < \"{$restoreFile}\"";
        } else {
            $command = "\"{$mysqlPath}\" -u {$db['username']} {$db['database']} < \"{$restoreFile}\"";
        }
    
        $result = null;
        $output = null;
    
        // Langsung jalankan dengan exec
        exec("cmd /c {$command}", $output, $result);
    
        if ($result === 0) {
            Storage::delete($path);
            return back()->with('success', 'Restore berhasil!');
        } else {
            return back()->with('error', 'Restore gagal. Periksa file SQL dan koneksi database.');
        }
    }    
}
