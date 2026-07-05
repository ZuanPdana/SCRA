<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLogService
{
    /**
     * Log an activity
     *
     * @param string $activityType Authentication, User Management, Classroom Management, Reservation, Profile, System
     * @param string $module Authentication, Users, Classrooms, Reservations, Reports, Profile, Admin, System
     * @param string $title Activity title in Indonesian
     * @param string|null $description Activity description in Indonesian
     * @param User|null $user User instance (defaults to authenticated user)
     */
    public static function log(
        string $activityType,
        string $module,
        string $title,
        ?string $description = null,
        ?User $user = null
    ): ActivityLog {
        $user = $user ?? Auth::user();

        return ActivityLog::create([
            'user_id' => $user?->id,
            'activity_type' => $activityType,
            'module' => $module,
            'title' => $title,
            'description' => $description,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }

    /**
     * Log login activity
     */
    public static function logLogin(User $user): ActivityLog
    {
        return self::log(
            'Authentication',
            'Authentication',
            'Login',
            "{$user->role->role_name} \"{$user->name}\" berhasil masuk ke sistem.",
            $user
        );
    }

    /**
     * Log logout activity
     */
    public static function logLogout(User $user): ActivityLog
    {
        return self::log(
            'Authentication',
            'Authentication',
            'Logout',
            "{$user->role->role_name} \"{$user->name}\" keluar dari sistem.",
            $user
        );
    }

    /**
     * Log failed login attempt
     */
    public static function logFailedLogin(string $email): ActivityLog
    {
        return self::log(
            'Authentication',
            'Authentication',
            'Gagal Login',
            "Percobaan login gagal untuk email: {$email}."
        );
    }

    /**
     * Log password change
     */
    public static function logPasswordChange(User $user): ActivityLog
    {
        return self::log(
            'Profile',
            'Profile',
            'Ubah Password',
            "{$user->role->role_name} \"{$user->name}\" mengubah password.",
            $user
        );
    }

    /**
     * Log profile update
     */
    public static function logProfileUpdate(User $user): ActivityLog
    {
        return self::log(
            'Profile',
            'Profile',
            'Perbarui Profil',
            "{$user->role->role_name} \"{$user->name}\" memperbarui informasi profil.",
            $user
        );
    }

    /**
     * Log user creation
     */
    public static function logUserCreated(User $createdUser, User $creator): ActivityLog
    {
        return self::log(
            'User Management',
            'Users',
            'Tambah Pengguna',
            "Admin menambahkan akun {$createdUser->role->role_name} \"{$createdUser->name}\".",
            $creator
        );
    }

    /**
     * Log user update
     */
    public static function logUserUpdated(User $updatedUser, User $updater): ActivityLog
    {
        return self::log(
            'User Management',
            'Users',
            'Perbarui Pengguna',
            "Admin memperbarui akun {$updatedUser->role->role_name} \"{$updatedUser->name}\".",
            $updater
        );
    }

    /**
     * Log user deletion
     */
    public static function logUserDeleted(string $userName, string $userRole, User $deleter): ActivityLog
    {
        return self::log(
            'User Management',
            'Users',
            'Hapus Pengguna',
            "Admin menghapus akun {$userRole} \"{$userName}\".",
            $deleter
        );
    }

    /**
     * Log classroom creation
     */
    public static function logClassroomCreated(string $classroomName, User $creator): ActivityLog
    {
        return self::log(
            'Classroom Management',
            'Classrooms',
            'Tambah Ruang Kelas',
            "Admin \"{$creator->name}\" menambahkan ruang kelas \"{$classroomName}\".",
            $creator
        );
    }

    /**
     * Log classroom update
     */
    public static function logClassroomUpdated(string $classroomName, User $updater): ActivityLog
    {
        return self::log(
            'Classroom Management',
            'Classrooms',
            'Perbarui Ruang Kelas',
            "Admin memperbarui data ruang kelas \"{$classroomName}\".",
            $updater
        );
    }

    /**
     * Log classroom deletion
     */
    public static function logClassroomDeleted(string $classroomName, User $deleter): ActivityLog
    {
        return self::log(
            'Classroom Management',
            'Classrooms',
            'Hapus Ruang Kelas',
            "Admin menghapus ruang kelas \"{$classroomName}\".",
            $deleter
        );
    }

    /**
     * Log reservation creation
     */
    public static function logReservationCreated(string $classroomName, User $creator): ActivityLog
    {
        return self::log(
            'Reservation',
            'Reservations',
            'Buat Reservasi',
            "{$creator->role->role_name} \"{$creator->name}\" membuat reservasi ruang \"{$classroomName}\".",
            $creator
        );
    }

    /**
     * Log reservation cancellation
     */
    public static function logReservationCancelled(string $classroomName, User $user): ActivityLog
    {
        return self::log(
            'Reservation',
            'Reservations',
            'Batalkan Reservasi',
            "{$user->role->role_name} membatalkan reservasi ruang \"{$classroomName}\".",
            $user
        );
    }

    /**
     * Log reservation approval
     */
    public static function logReservationApproved(string $classroomName, User $approver): ActivityLog
    {
        return self::log(
            'Reservation',
            'Reservations',
            'Reservasi Disetujui',
            "{$approver->role->role_name} \"{$approver->name}\" menyetujui reservasi ruang \"{$classroomName}\".",
            $approver
        );
    }

    /**
     * Log reservation rejection
     */
    public static function logReservationRejected(string $classroomName, User $rejector): ActivityLog
    {
        return self::log(
            'Reservation',
            'Reservations',
            'Reservasi Ditolak',
            "{$rejector->role->role_name} \"{$rejector->name}\" menolak reservasi ruang \"{$classroomName}\".",
            $rejector
        );
    }

    /**
     * Log reservation status change
     */
    public static function logReservationStatusChanged(string $status, User $changer): ActivityLog
    {
        return self::log(
            'Reservation',
            'Reservations',
            'Status Reservasi Diubah',
            "Admin mengubah status reservasi menjadi \"{$status}\".",
            $changer
        );
    }
}
