<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Log;

class DatabaseController extends Controller
{
    public function index()
    {
        return view('backup.index');
    }

    public function backup()
    {
        $dbName = env('DB_DATABASE');
        $dbUser = env('DB_USERNAME');
        $dbPass = env('DB_PASSWORD');
        $dbHost = env('DB_HOST', '127.0.0.1');
        $fileName = 'ukk2223_p1aziz' . '.sql';
        $backupPath = storage_path("app/backup/{$fileName}");
    
        // Membuat direktori backup jika belum ada
        if (!is_dir(storage_path('app/backup'))) {
            mkdir(storage_path('app/backup'), 0755, true);
        }
    
        // Path ke mysqldump
        $mysqldumpPath = "C:\\laragon\\bin\\mysql\\mysql-8.0.30-winx64\\bin\\mysqldump";
    
        // Membuat perintah backup
        $command = "\"{$mysqldumpPath}\" --host={$dbHost} --user={$dbUser} --password=\"{$dbPass}\" --routines --triggers {$dbName} > \"{$backupPath}\"";
    
        // Debug: Log perintah yang dijalankan
        Log::info("Backup command: {$command}");
    
        // Menjalankan perintah backup
        $result = null;
        $output = null;
        exec($command, $output, $result);
    
        // Memeriksa apakah perintah berhasil
        if ($result !== 0) {
            return back()->with('error', 'Backup gagal. Periksa konfigurasi database dan hak akses.');
        }
    
        // Redirect with success message
        return redirect()->route('Database.index')->with('success', 'Backup berhasil disimpan.');
    }
    
    public function downloadBackup()
    {
        $fileName = 'ukk2223_p1aziz.sql';
        $backupPath = storage_path("app/backup/{$fileName}");
    
        // Check if the backup file exists before attempting to download
        if (!file_exists($backupPath)) {
            return back()->with('error', 'Backup file tidak ditemukan.');
        }
    
        // Return the download response
        return response()->download($backupPath);
    }    

    public function restore(Request $request)
    {
        // Validasi file yang diupload
        $request->validate([
            'backup_file' => 'required|mimes:sql'
        ]);

        // Ambil file yang diupload
        $file = $request->file('backup_file');
        
        // Simpan file dengan nama asli
        $path = $file->storeAs('backup', $file->getClientOriginalName());

        // Debug: Log path file yang disimpan
        Log::info("Backup file stored at: " . storage_path("app/{$path}"));

        // Ambil konfigurasi database
        $db = config('database.connections.mysql');
        $restoreFile = storage_path("app/{$path}");

        // Path ke mysql
        $mysqlPath = "C:\\laragon\\bin\\mysql\\mysql-8.0.30-winx64\\bin\\mysql";

        // Perintah untuk restore
        $command = "\"{$mysqlPath}\" -u {$db['username']} -p\"{$db['password']}\" {$db['database']} < \"{$restoreFile}\"";

        // Debug: Log perintah restore
        Log::info("Restore command: {$command}");

        // Jalankan perintah dengan Symfony Process
        $process = new Process([$command]);
        $process->run();

        // Debugging output jika ada kesalahan
        if ($process->isSuccessful()) {
            // Hapus file backup setelah restore sukses
            Storage::delete($path);
            Log::info('Restore berhasil.');
            return back()->with('success', 'Restore berhasil!');
        } else {
            // Log error jika restore gagal
            Log::error('Restore failed', [
                'error' => $process->getErrorOutput(),
                'exit_code' => $process->getExitCode()
            ]);
            // Debugging output
            dd('Error output:', $process->getErrorOutput(), 'Exit code:', $process->getExitCode());
        }
    }
}
