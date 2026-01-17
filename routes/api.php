<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
    // Permissions
    Route::apiResource('permissions', 'PermissionsApiController');

    // Roles
    Route::apiResource('roles', 'RolesApiController');

    // Users
    Route::apiResource('users', 'UsersApiController');

    // User Alerts
    Route::apiResource('user-alerts', 'UserAlertsApiController');

    // Student
    Route::post('students/media', 'StudentApiController@storeMedia')->name('students.storeMedia');
    Route::apiResource('students', 'StudentApiController');

    // Teacher
    Route::post('teachers/media', 'TeacherApiController@storeMedia')->name('teachers.storeMedia');
    Route::apiResource('teachers', 'TeacherApiController');

    // Batch
    Route::apiResource('batches', 'BatchApiController');

    // Class Level
    Route::post('class-levels/media', 'ClassLevelApiController@storeMedia')->name('class-levels.storeMedia');
    Route::apiResource('class-levels', 'ClassLevelApiController');

    // Subject
    Route::post('subjects/media', 'SubjectApiController@storeMedia')->name('subjects.storeMedia');
    Route::apiResource('subjects', 'SubjectApiController');

    // Batch Student
    Route::apiResource('batch-students', 'BatchStudentApiController');

    // Payment
    Route::apiResource('payments', 'PaymentApiController');

    // Attendance
    Route::post('attendances/media', 'AttendanceApiController@storeMedia')->name('attendances.storeMedia');
    Route::apiResource('attendances', 'AttendanceApiController');

    // Chapter
    Route::apiResource('chapters', 'ChapterApiController');

    // Test
    Route::post('tests/media', 'TestApiController@storeMedia')->name('tests.storeMedia');
    Route::apiResource('tests', 'TestApiController');

    // Question
    Route::post('questions/media', 'QuestionApiController@storeMedia')->name('questions.storeMedia');
    Route::apiResource('questions', 'QuestionApiController');

    // Study Material
    Route::post('study-materials/media', 'StudyMaterialApiController@storeMedia')->name('study-materials.storeMedia');
    Route::apiResource('study-materials', 'StudyMaterialApiController');

    // Live Class
    Route::post('live-classes/media', 'LiveClassApiController@storeMedia')->name('live-classes.storeMedia');
    Route::apiResource('live-classes', 'LiveClassApiController');

    // Academic Session
    Route::apiResource('academic-sessions', 'AcademicSessionApiController');

    // Announcement
    Route::post('announcements/media', 'AnnouncementApiController@storeMedia')->name('announcements.storeMedia');
    Route::apiResource('announcements', 'AnnouncementApiController');

    // Contact Detail
    Route::apiResource('contact-details', 'ContactDetailApiController');

    // Enquiry
    Route::apiResource('enquiries', 'EnquiryApiController');

    // Logo
    Route::post('logos/media', 'LogoApiController@storeMedia')->name('logos.storeMedia');
    Route::apiResource('logos', 'LogoApiController');

    // Crousel
    Route::post('crousels/media', 'CrouselApiController@storeMedia')->name('crousels.storeMedia');
    Route::apiResource('crousels', 'CrouselApiController');
});
