<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'audit_log_show',
            ],
            [
                'id'    => 18,
                'title' => 'audit_log_access',
            ],
            [
                'id'    => 19,
                'title' => 'user_alert_create',
            ],
            [
                'id'    => 20,
                'title' => 'user_alert_edit',
            ],
            [
                'id'    => 21,
                'title' => 'user_alert_show',
            ],
            [
                'id'    => 22,
                'title' => 'user_alert_delete',
            ],
            [
                'id'    => 23,
                'title' => 'user_alert_access',
            ],
            [
                'id'    => 24,
                'title' => 'student_create',
            ],
            [
                'id'    => 25,
                'title' => 'student_edit',
            ],
            [
                'id'    => 26,
                'title' => 'student_show',
            ],
            [
                'id'    => 27,
                'title' => 'student_delete',
            ],
            [
                'id'    => 28,
                'title' => 'student_access',
            ],
            [
                'id'    => 29,
                'title' => 'teacher_create',
            ],
            [
                'id'    => 30,
                'title' => 'teacher_edit',
            ],
            [
                'id'    => 31,
                'title' => 'teacher_show',
            ],
            [
                'id'    => 32,
                'title' => 'teacher_delete',
            ],
            [
                'id'    => 33,
                'title' => 'teacher_access',
            ],
            [
                'id'    => 34,
                'title' => 'batch_create',
            ],
            [
                'id'    => 35,
                'title' => 'batch_edit',
            ],
            [
                'id'    => 36,
                'title' => 'batch_show',
            ],
            [
                'id'    => 37,
                'title' => 'batch_delete',
            ],
            [
                'id'    => 38,
                'title' => 'batch_access',
            ],
            [
                'id'    => 39,
                'title' => 'course_access',
            ],
            [
                'id'    => 40,
                'title' => 'class_level_create',
            ],
            [
                'id'    => 41,
                'title' => 'class_level_edit',
            ],
            [
                'id'    => 42,
                'title' => 'class_level_show',
            ],
            [
                'id'    => 43,
                'title' => 'class_level_delete',
            ],
            [
                'id'    => 44,
                'title' => 'class_level_access',
            ],
            [
                'id'    => 45,
                'title' => 'subject_create',
            ],
            [
                'id'    => 46,
                'title' => 'subject_edit',
            ],
            [
                'id'    => 47,
                'title' => 'subject_show',
            ],
            [
                'id'    => 48,
                'title' => 'subject_delete',
            ],
            [
                'id'    => 49,
                'title' => 'subject_access',
            ],
            [
                'id'    => 50,
                'title' => 'enrollment_access',
            ],
            [
                'id'    => 51,
                'title' => 'batch_student_create',
            ],
            [
                'id'    => 52,
                'title' => 'batch_student_edit',
            ],
            [
                'id'    => 53,
                'title' => 'batch_student_show',
            ],
            [
                'id'    => 54,
                'title' => 'batch_student_delete',
            ],
            [
                'id'    => 55,
                'title' => 'batch_student_access',
            ],
            [
                'id'    => 56,
                'title' => 'payment_create',
            ],
            [
                'id'    => 57,
                'title' => 'payment_edit',
            ],
            [
                'id'    => 58,
                'title' => 'payment_show',
            ],
            [
                'id'    => 59,
                'title' => 'payment_delete',
            ],
            [
                'id'    => 60,
                'title' => 'payment_access',
            ],
            [
                'id'    => 61,
                'title' => 'attendance_create',
            ],
            [
                'id'    => 62,
                'title' => 'attendance_edit',
            ],
            [
                'id'    => 63,
                'title' => 'attendance_show',
            ],
            [
                'id'    => 64,
                'title' => 'attendance_delete',
            ],
            [
                'id'    => 65,
                'title' => 'attendance_access',
            ],
            [
                'id'    => 66,
                'title' => 'chapter_create',
            ],
            [
                'id'    => 67,
                'title' => 'chapter_edit',
            ],
            [
                'id'    => 68,
                'title' => 'chapter_show',
            ],
            [
                'id'    => 69,
                'title' => 'chapter_delete',
            ],
            [
                'id'    => 70,
                'title' => 'chapter_access',
            ],
            [
                'id'    => 71,
                'title' => 'exam_system_access',
            ],
            [
                'id'    => 72,
                'title' => 'test_create',
            ],
            [
                'id'    => 73,
                'title' => 'test_edit',
            ],
            [
                'id'    => 74,
                'title' => 'test_show',
            ],
            [
                'id'    => 75,
                'title' => 'test_delete',
            ],
            [
                'id'    => 76,
                'title' => 'test_access',
            ],
            [
                'id'    => 77,
                'title' => 'question_create',
            ],
            [
                'id'    => 78,
                'title' => 'question_edit',
            ],
            [
                'id'    => 79,
                'title' => 'question_show',
            ],
            [
                'id'    => 80,
                'title' => 'question_delete',
            ],
            [
                'id'    => 81,
                'title' => 'question_access',
            ],
            [
                'id'    => 82,
                'title' => 'study_material_create',
            ],
            [
                'id'    => 83,
                'title' => 'study_material_edit',
            ],
            [
                'id'    => 84,
                'title' => 'study_material_show',
            ],
            [
                'id'    => 85,
                'title' => 'study_material_delete',
            ],
            [
                'id'    => 86,
                'title' => 'study_material_access',
            ],
            [
                'id'    => 87,
                'title' => 'live_class_create',
            ],
            [
                'id'    => 88,
                'title' => 'live_class_edit',
            ],
            [
                'id'    => 89,
                'title' => 'live_class_show',
            ],
            [
                'id'    => 90,
                'title' => 'live_class_delete',
            ],
            [
                'id'    => 91,
                'title' => 'live_class_access',
            ],
            [
                'id'    => 92,
                'title' => 'academic_session_create',
            ],
            [
                'id'    => 93,
                'title' => 'academic_session_edit',
            ],
            [
                'id'    => 94,
                'title' => 'academic_session_show',
            ],
            [
                'id'    => 95,
                'title' => 'academic_session_delete',
            ],
            [
                'id'    => 96,
                'title' => 'academic_session_access',
            ],
            [
                'id'    => 97,
                'title' => 'announcement_create',
            ],
            [
                'id'    => 98,
                'title' => 'announcement_edit',
            ],
            [
                'id'    => 99,
                'title' => 'announcement_show',
            ],
            [
                'id'    => 100,
                'title' => 'announcement_delete',
            ],
            [
                'id'    => 101,
                'title' => 'announcement_access',
            ],
            [
                'id'    => 102,
                'title' => 'website_setup_access',
            ],
            [
                'id'    => 103,
                'title' => 'contact_detail_create',
            ],
            [
                'id'    => 104,
                'title' => 'contact_detail_edit',
            ],
            [
                'id'    => 105,
                'title' => 'contact_detail_show',
            ],
            [
                'id'    => 106,
                'title' => 'contact_detail_delete',
            ],
            [
                'id'    => 107,
                'title' => 'contact_detail_access',
            ],
            [
                'id'    => 108,
                'title' => 'enquiry_create',
            ],
            [
                'id'    => 109,
                'title' => 'enquiry_edit',
            ],
            [
                'id'    => 110,
                'title' => 'enquiry_show',
            ],
            [
                'id'    => 111,
                'title' => 'enquiry_delete',
            ],
            [
                'id'    => 112,
                'title' => 'enquiry_access',
            ],
            [
                'id'    => 113,
                'title' => 'logo_create',
            ],
            [
                'id'    => 114,
                'title' => 'logo_edit',
            ],
            [
                'id'    => 115,
                'title' => 'logo_show',
            ],
            [
                'id'    => 116,
                'title' => 'logo_delete',
            ],
            [
                'id'    => 117,
                'title' => 'logo_access',
            ],
            [
                'id'    => 118,
                'title' => 'crousel_create',
            ],
            [
                'id'    => 119,
                'title' => 'crousel_edit',
            ],
            [
                'id'    => 120,
                'title' => 'crousel_show',
            ],
            [
                'id'    => 121,
                'title' => 'crousel_delete',
            ],
            [
                'id'    => 122,
                'title' => 'crousel_access',
            ],
            [
                'id'    => 123,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
