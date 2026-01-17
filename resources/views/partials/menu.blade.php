<div id="sidebar" class="c-sidebar c-sidebar-fixed c-sidebar-lg-show">

    <div class="c-sidebar-brand d-md-down-none">
        <a class="c-sidebar-brand-full h4" href="#">
            {{ trans('panel.site_title') }}
        </a>
    </div>

    <ul class="c-sidebar-nav">
        <li class="c-sidebar-nav-item">
            <a href="{{ route("admin.home") }}" class="c-sidebar-nav-link">
                <i class="c-sidebar-nav-icon fas fa-fw fa-tachometer-alt">

                </i>
                {{ trans('global.dashboard') }}
            </a>
        </li>
        @can('user_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/permissions*") ? "c-show" : "" }} {{ request()->is("admin/roles*") ? "c-show" : "" }} {{ request()->is("admin/users*") ? "c-show" : "" }} {{ request()->is("admin/audit-logs*") ? "c-show" : "" }} {{ request()->is("admin/user-alerts*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-users c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.userManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('permission_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.permissions.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/permissions") || request()->is("admin/permissions/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-unlock-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.permission.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('role_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.roles.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/roles") || request()->is("admin/roles/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-briefcase c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.role.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('user_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.users.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/users") || request()->is("admin/users/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.user.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('audit_log_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.audit-logs.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/audit-logs") || request()->is("admin/audit-logs/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-file-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.auditLog.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('user_alert_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.user-alerts.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/user-alerts") || request()->is("admin/user-alerts/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-bell c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.userAlert.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('student_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.students.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/students") || request()->is("admin/students/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.student.title') }}
                </a>
            </li>
        @endcan
        @can('teacher_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.teachers.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/teachers") || request()->is("admin/teachers/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.teacher.title') }}
                </a>
            </li>
        @endcan
        @can('course_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/academic-sessions*") ? "c-show" : "" }} {{ request()->is("admin/class-levels*") ? "c-show" : "" }} {{ request()->is("admin/subjects*") ? "c-show" : "" }} {{ request()->is("admin/batches*") ? "c-show" : "" }} {{ request()->is("admin/chapters*") ? "c-show" : "" }} {{ request()->is("admin/study-materials*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.course.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('academic_session_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.academic-sessions.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/academic-sessions") || request()->is("admin/academic-sessions/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.academicSession.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('class_level_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.class-levels.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/class-levels") || request()->is("admin/class-levels/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.classLevel.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('subject_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.subjects.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/subjects") || request()->is("admin/subjects/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.subject.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('batch_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.batches.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/batches") || request()->is("admin/batches/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.batch.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('chapter_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.chapters.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/chapters") || request()->is("admin/chapters/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.chapter.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('study_material_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.study-materials.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/study-materials") || request()->is("admin/study-materials/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.studyMaterial.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('enrollment_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/batch-students*") ? "c-show" : "" }} {{ request()->is("admin/live-classes*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.enrollment.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('batch_student_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.batch-students.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/batch-students") || request()->is("admin/batch-students/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.batchStudent.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('live_class_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.live-classes.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/live-classes") || request()->is("admin/live-classes/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.liveClass.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('payment_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.payments.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/payments") || request()->is("admin/payments/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.payment.title') }}
                </a>
            </li>
        @endcan
        @can('attendance_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.attendances.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/attendances") || request()->is("admin/attendances/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.attendance.title') }}
                </a>
            </li>
        @endcan
        @can('exam_system_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/tests*") ? "c-show" : "" }} {{ request()->is("admin/questions*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.examSystem.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('test_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.tests.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/tests") || request()->is("admin/tests/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.test.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('question_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.questions.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/questions") || request()->is("admin/questions/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.question.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('announcement_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.announcements.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/announcements") || request()->is("admin/announcements/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.announcement.title') }}
                </a>
            </li>
        @endcan
        @can('website_setup_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/contact-details*") ? "c-show" : "" }} {{ request()->is("admin/enquiries*") ? "c-show" : "" }} {{ request()->is("admin/logos*") ? "c-show" : "" }} {{ request()->is("admin/crousels*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.websiteSetup.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('contact_detail_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.contact-details.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/contact-details") || request()->is("admin/contact-details/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.contactDetail.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('enquiry_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.enquiries.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/enquiries") || request()->is("admin/enquiries/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.enquiry.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('logo_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.logos.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/logos") || request()->is("admin/logos/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.logo.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('crousel_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.crousels.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/crousels") || request()->is("admin/crousels/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.crousel.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
            @can('profile_password_edit')
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'c-active' : '' }}" href="{{ route('profile.password.edit') }}">
                        <i class="fa-fw fas fa-key c-sidebar-nav-icon">
                        </i>
                        {{ trans('global.change_password') }}
                    </a>
                </li>
            @endcan
        @endif
        <li class="c-sidebar-nav-item">
            <a href="#" class="c-sidebar-nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                <i class="c-sidebar-nav-icon fas fa-fw fa-sign-out-alt">

                </i>
                {{ trans('global.logout') }}
            </a>
        </li>
    </ul>

</div>