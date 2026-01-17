<?php
use App\Http\Controllers\Teacher\AttendanceController;
use App\Http\Controllers\Teacher\BatchController;
use App\Http\Controllers\Teacher\DashboardController;
use App\Http\Controllers\Teacher\LiveClassController;
use App\Http\Controllers\Teacher\TestController;

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes();

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::post('permissions/parse-csv-import', 'PermissionsController@parseCsvImport')->name('permissions.parseCsvImport');
    Route::post('permissions/process-csv-import', 'PermissionsController@processCsvImport')->name('permissions.processCsvImport');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::post('roles/parse-csv-import', 'RolesController@parseCsvImport')->name('roles.parseCsvImport');
    Route::post('roles/process-csv-import', 'RolesController@processCsvImport')->name('roles.processCsvImport');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::post('users/parse-csv-import', 'UsersController@parseCsvImport')->name('users.parseCsvImport');
    Route::post('users/process-csv-import', 'UsersController@processCsvImport')->name('users.processCsvImport');
    Route::resource('users', 'UsersController');

    // Audit Logs
    Route::resource('audit-logs', 'AuditLogsController', ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);

    // User Alerts
    Route::delete('user-alerts/destroy', 'UserAlertsController@massDestroy')->name('user-alerts.massDestroy');
    Route::post('user-alerts/parse-csv-import', 'UserAlertsController@parseCsvImport')->name('user-alerts.parseCsvImport');
    Route::post('user-alerts/process-csv-import', 'UserAlertsController@processCsvImport')->name('user-alerts.processCsvImport');
    Route::get('user-alerts/read', 'UserAlertsController@read');
    Route::resource('user-alerts', 'UserAlertsController');

    // Student
    Route::delete('students/destroy', 'StudentController@massDestroy')->name('students.massDestroy');
    Route::post('students/media', 'StudentController@storeMedia')->name('students.storeMedia');
    Route::post('students/ckmedia', 'StudentController@storeCKEditorImages')->name('students.storeCKEditorImages');
    Route::post('students/parse-csv-import', 'StudentController@parseCsvImport')->name('students.parseCsvImport');
    Route::post('students/process-csv-import', 'StudentController@processCsvImport')->name('students.processCsvImport');
    Route::resource('students', 'StudentController');

    // Teacher
    Route::delete('teachers/destroy', 'TeacherController@massDestroy')->name('teachers.massDestroy');
    Route::post('teachers/media', 'TeacherController@storeMedia')->name('teachers.storeMedia');
    Route::post('teachers/ckmedia', 'TeacherController@storeCKEditorImages')->name('teachers.storeCKEditorImages');
    Route::post('teachers/parse-csv-import', 'TeacherController@parseCsvImport')->name('teachers.parseCsvImport');
    Route::post('teachers/process-csv-import', 'TeacherController@processCsvImport')->name('teachers.processCsvImport');
    Route::resource('teachers', 'TeacherController');

    // Batch
    Route::delete('batches/destroy', 'BatchController@massDestroy')->name('batches.massDestroy');
    Route::post('batches/parse-csv-import', 'BatchController@parseCsvImport')->name('batches.parseCsvImport');
    Route::post('batches/process-csv-import', 'BatchController@processCsvImport')->name('batches.processCsvImport');
    Route::resource('batches', 'BatchController');

    // Class Level
    Route::delete('class-levels/destroy', 'ClassLevelController@massDestroy')->name('class-levels.massDestroy');
    Route::post('class-levels/media', 'ClassLevelController@storeMedia')->name('class-levels.storeMedia');
    Route::post('class-levels/ckmedia', 'ClassLevelController@storeCKEditorImages')->name('class-levels.storeCKEditorImages');
    Route::post('class-levels/parse-csv-import', 'ClassLevelController@parseCsvImport')->name('class-levels.parseCsvImport');
    Route::post('class-levels/process-csv-import', 'ClassLevelController@processCsvImport')->name('class-levels.processCsvImport');
    Route::resource('class-levels', 'ClassLevelController');

    // Subject
    Route::delete('subjects/destroy', 'SubjectController@massDestroy')->name('subjects.massDestroy');
    Route::post('subjects/media', 'SubjectController@storeMedia')->name('subjects.storeMedia');
    Route::post('subjects/ckmedia', 'SubjectController@storeCKEditorImages')->name('subjects.storeCKEditorImages');
    Route::post('subjects/parse-csv-import', 'SubjectController@parseCsvImport')->name('subjects.parseCsvImport');
    Route::post('subjects/process-csv-import', 'SubjectController@processCsvImport')->name('subjects.processCsvImport');
    Route::resource('subjects', 'SubjectController');

    // Batch Student
    Route::delete('batch-students/destroy', 'BatchStudentController@massDestroy')->name('batch-students.massDestroy');
    Route::post('batch-students/parse-csv-import', 'BatchStudentController@parseCsvImport')->name('batch-students.parseCsvImport');
    Route::post('batch-students/process-csv-import', 'BatchStudentController@processCsvImport')->name('batch-students.processCsvImport');
    Route::resource('batch-students', 'BatchStudentController');

    // Payment
    Route::delete('payments/destroy', 'PaymentController@massDestroy')->name('payments.massDestroy');
    Route::post('payments/parse-csv-import', 'PaymentController@parseCsvImport')->name('payments.parseCsvImport');
    Route::post('payments/process-csv-import', 'PaymentController@processCsvImport')->name('payments.processCsvImport');
    Route::resource('payments', 'PaymentController');

    // Attendance
    Route::delete('attendances/destroy', 'AttendanceController@massDestroy')->name('attendances.massDestroy');
    Route::post('attendances/media', 'AttendanceController@storeMedia')->name('attendances.storeMedia');
    Route::post('attendances/ckmedia', 'AttendanceController@storeCKEditorImages')->name('attendances.storeCKEditorImages');
    Route::post('attendances/parse-csv-import', 'AttendanceController@parseCsvImport')->name('attendances.parseCsvImport');
    Route::post('attendances/process-csv-import', 'AttendanceController@processCsvImport')->name('attendances.processCsvImport');
    Route::resource('attendances', 'AttendanceController');

    // Chapter
    Route::delete('chapters/destroy', 'ChapterController@massDestroy')->name('chapters.massDestroy');
    Route::post('chapters/parse-csv-import', 'ChapterController@parseCsvImport')->name('chapters.parseCsvImport');
    Route::post('chapters/process-csv-import', 'ChapterController@processCsvImport')->name('chapters.processCsvImport');
    Route::resource('chapters', 'ChapterController');

    // Test
    Route::delete('tests/destroy', 'TestController@massDestroy')->name('tests.massDestroy');
    Route::post('tests/media', 'TestController@storeMedia')->name('tests.storeMedia');
    Route::post('tests/ckmedia', 'TestController@storeCKEditorImages')->name('tests.storeCKEditorImages');
    Route::post('tests/parse-csv-import', 'TestController@parseCsvImport')->name('tests.parseCsvImport');
    Route::post('tests/process-csv-import', 'TestController@processCsvImport')->name('tests.processCsvImport');
    Route::resource('tests', 'TestController');

    // Question
    Route::delete('questions/destroy', 'QuestionController@massDestroy')->name('questions.massDestroy');
    Route::post('questions/media', 'QuestionController@storeMedia')->name('questions.storeMedia');
    Route::post('questions/ckmedia', 'QuestionController@storeCKEditorImages')->name('questions.storeCKEditorImages');
    Route::post('questions/parse-csv-import', 'QuestionController@parseCsvImport')->name('questions.parseCsvImport');
    Route::post('questions/process-csv-import', 'QuestionController@processCsvImport')->name('questions.processCsvImport');
    Route::resource('questions', 'QuestionController');

    // Study Material
    Route::delete('study-materials/destroy', 'StudyMaterialController@massDestroy')->name('study-materials.massDestroy');
    Route::post('study-materials/media', 'StudyMaterialController@storeMedia')->name('study-materials.storeMedia');
    Route::post('study-materials/ckmedia', 'StudyMaterialController@storeCKEditorImages')->name('study-materials.storeCKEditorImages');
    Route::post('study-materials/parse-csv-import', 'StudyMaterialController@parseCsvImport')->name('study-materials.parseCsvImport');
    Route::post('study-materials/process-csv-import', 'StudyMaterialController@processCsvImport')->name('study-materials.processCsvImport');
    Route::resource('study-materials', 'StudyMaterialController');

    // Live Class
    Route::delete('live-classes/destroy', 'LiveClassController@massDestroy')->name('live-classes.massDestroy');
    Route::post('live-classes/media', 'LiveClassController@storeMedia')->name('live-classes.storeMedia');
    Route::post('live-classes/ckmedia', 'LiveClassController@storeCKEditorImages')->name('live-classes.storeCKEditorImages');
    Route::post('live-classes/parse-csv-import', 'LiveClassController@parseCsvImport')->name('live-classes.parseCsvImport');
    Route::post('live-classes/process-csv-import', 'LiveClassController@processCsvImport')->name('live-classes.processCsvImport');
    Route::resource('live-classes', 'LiveClassController');

    // Academic Session
    Route::delete('academic-sessions/destroy', 'AcademicSessionController@massDestroy')->name('academic-sessions.massDestroy');
    Route::post('academic-sessions/parse-csv-import', 'AcademicSessionController@parseCsvImport')->name('academic-sessions.parseCsvImport');
    Route::post('academic-sessions/process-csv-import', 'AcademicSessionController@processCsvImport')->name('academic-sessions.processCsvImport');
    Route::resource('academic-sessions', 'AcademicSessionController');

    // Announcement
    Route::delete('announcements/destroy', 'AnnouncementController@massDestroy')->name('announcements.massDestroy');
    Route::post('announcements/media', 'AnnouncementController@storeMedia')->name('announcements.storeMedia');
    Route::post('announcements/ckmedia', 'AnnouncementController@storeCKEditorImages')->name('announcements.storeCKEditorImages');
    Route::post('announcements/parse-csv-import', 'AnnouncementController@parseCsvImport')->name('announcements.parseCsvImport');
    Route::post('announcements/process-csv-import', 'AnnouncementController@processCsvImport')->name('announcements.processCsvImport');
    Route::resource('announcements', 'AnnouncementController');

    // Contact Detail
    Route::delete('contact-details/destroy', 'ContactDetailController@massDestroy')->name('contact-details.massDestroy');
    Route::post('contact-details/parse-csv-import', 'ContactDetailController@parseCsvImport')->name('contact-details.parseCsvImport');
    Route::post('contact-details/process-csv-import', 'ContactDetailController@processCsvImport')->name('contact-details.processCsvImport');
    Route::resource('contact-details', 'ContactDetailController');

    // Enquiry
    Route::delete('enquiries/destroy', 'EnquiryController@massDestroy')->name('enquiries.massDestroy');
    Route::post('enquiries/parse-csv-import', 'EnquiryController@parseCsvImport')->name('enquiries.parseCsvImport');
    Route::post('enquiries/process-csv-import', 'EnquiryController@processCsvImport')->name('enquiries.processCsvImport');
    Route::resource('enquiries', 'EnquiryController');

    // Logo
    Route::delete('logos/destroy', 'LogoController@massDestroy')->name('logos.massDestroy');
    Route::post('logos/media', 'LogoController@storeMedia')->name('logos.storeMedia');
    Route::post('logos/ckmedia', 'LogoController@storeCKEditorImages')->name('logos.storeCKEditorImages');
    Route::post('logos/parse-csv-import', 'LogoController@parseCsvImport')->name('logos.parseCsvImport');
    Route::post('logos/process-csv-import', 'LogoController@processCsvImport')->name('logos.processCsvImport');
    Route::resource('logos', 'LogoController');

    // Crousel
    Route::delete('crousels/destroy', 'CrouselController@massDestroy')->name('crousels.massDestroy');
    Route::post('crousels/media', 'CrouselController@storeMedia')->name('crousels.storeMedia');
    Route::post('crousels/ckmedia', 'CrouselController@storeCKEditorImages')->name('crousels.storeCKEditorImages');
    Route::post('crousels/parse-csv-import', 'CrouselController@parseCsvImport')->name('crousels.parseCsvImport');
    Route::post('crousels/process-csv-import', 'CrouselController@processCsvImport')->name('crousels.processCsvImport');
    Route::resource('crousels', 'CrouselController');

});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});

 Route::middleware(['auth', 'teacher'])
    ->prefix('teacher')
    ->name('teacher.')
    ->group(function () {

        // 🔹 Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        // 🔹 My Batches
        Route::get('/batches', [BatchController::class, 'index'])
            ->name('batches');

        Route::get('/batches/{batch}/students',
            [BatchController::class, 'students']
        )->name('batches.students');

        // 🔹 Attendance
        Route::get('/attendance', [AttendanceController::class, 'index'])
            ->name('attendance');

             Route::get(
            '/batches/{batch}/attendance/today',
            [AttendanceController::class, 'todayBatch']
        )->name('batches.attendance.today');

        Route::get(
            '/batches/{batch}/students/{student}/attendance-history',
            [AttendanceController::class, 'studentHistory']
        )->name('batches.students.attendance.history');
        // (future) mark attendance
        // Route::post('/attendance/mark', [AttendanceController::class, 'store'])
        //     ->name('attendance.store');

        /*
        |--------------------------------------------------------------------------
        | TESTS (Exam + Practice)
        |--------------------------------------------------------------------------
        */
        Route::get(
            '/batches/{batch}/tests',
            [TestController::class, 'index']
        )->name('batches.tests');

        Route::get(
            '/batches/{batch}/tests/create',
            [TestController::class, 'create']
        )->name('batches.tests.create');

        Route::post(
            '/batches/{batch}/tests',
            [TestController::class, 'store']
        )->name('batches.tests.store');
        Route::post(
    '/tests/{test}/toggle-publish',
    [TestController::class, 'togglePublish']
)->name('tests.toggle-publish');


        /*
        |--------------------------------------------------------------------------
        | QUESTIONS (MCQ)
        |--------------------------------------------------------------------------
        */
        Route::get(
            '/tests/{test}/questions',
            [TestController::class, 'questions']
        )->name('tests.questions');

        Route::post(
            '/tests/{test}/questions',
            [TestController::class, 'storeQuestion']
        )->name('tests.questions.store');

        Route::get(
    '/batches/{batch}/tests/results',
    [TestController::class, 'results']
)->name('batches.tests.results');



        // 🔹 Live Classes

        Route::get(
    'live-classes',
    [LiveClassController::class, 'all']
)->name('live-classes');
        
Route::get(
    'batches/{batch}/live-classes',
    [LiveClassController::class, 'index']
)->name('batches.live-classes');
Route::get(
    '/tests/{test}/results/students',
    [TestController::class, 'studentResults']
)->name('tests.results.students');


Route::get(
    '/tests/{test}/students/{batchStudent}/result',
    [TestController::class, 'studentResultDetail']
)->name('tests.results.student-detail');

Route::get(
    '/tests/attempts/{attempt}/answers',
    [TestController::class, 'attemptAnswers']
)->name('tests.attempt.answers');




        Route::get(
            '/batches/{batch}/live-classes/create',
            [LiveClassController::class, 'create']
        )->name('batches.live-classes.create');

        Route::post(
            '/batches/{batch}/live-classes',
            [LiveClassController::class, 'store']
        )->name('batches.live-classes.store');


    });


Route::middleware(['auth', 'student'])
    ->prefix('student')
    ->name('student.')
    ->group(function () {

        Route::get('/dashboard', [\App\Http\Controllers\Student\DashboardController::class, 'index'])
            ->name('dashboard');

             Route::get(
            '/batches',
            [\App\Http\Controllers\Student\BatchController::class, 'index']
        )->name('batches');

        Route::get(
            '/batches/{batch}',
            [\App\Http\Controllers\Student\BatchController::class, 'show']
        )->name('batches.show');

        Route::get(
            '/attendance',
            [\App\Http\Controllers\Student\AttendanceController::class, 'index']
        )->name('attendance');


        Route::get(
            '/live-classes',
            [\App\Http\Controllers\Student\LiveClassController::class, 'index']
        )->name('live-classes');

          // Tests list
        Route::get('/tests', [
            \App\Http\Controllers\Student\TestAttemptController::class,
            'index'
        ])->name('tests');

        // Start test
        Route::get('/tests/{test}/start', [
            \App\Http\Controllers\Student\TestAttemptController::class,
            'start'
        ])->name('tests.start');

        // Submit test
        Route::post('/tests/{test}/submit', [
            \App\Http\Controllers\Student\TestAttemptController::class,
            'submit'
        ])->name('tests.submit');

          // 1. All batches result
        Route::get('/results', 
            [\App\Http\Controllers\Student\TestResultController::class, 'batches']
        )->name('results');

        // 2. Batch → Tests result
        Route::get('/results/batch/{batch}', 
            [\App\Http\Controllers\Student\TestResultController::class, 'tests']
        )->name('results.batch');

        // 3. Test → Attempts result
        Route::get('/results/test/{test}', 
            [\App\Http\Controllers\Student\TestResultController::class, 'attempts']
        )->name('results.test');

        // 4. Single Attempt Detail
        Route::get('/results/attempt/{attempt}', 
            [\App\Http\Controllers\Student\TestResultController::class, 'attemptDetail']
        )->name('results.attempt');
       
    });
