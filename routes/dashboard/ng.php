<?php

return [

    // Route structure: {name} => [{url}, {controller_path}, {template_path}]

    // Basic Routes
    'home' => ['/', 'homeController', 'home'],
    '404' => ['/404', 'basics/notFoundController', 'basics.404'],

    // Profile Routes
    'profile.info' => ['/profile/info', 'profile/profileInfoController', 'profile.info'],
    'profile.password' => ['/profile/password', 'profile/profilePasswordController', 'profile.password'],
    'profile.employment_data' => ['/profile/employment-data', 'profile/profileEmploymentDataController', 'profile.employment_data'],
    'profile.residence_data' => ['/profile/residence-data', 'profile/profileResidenceDataController', 'profile.residence_data'],
    'profile.contact_data' => ['/profile/contact-data', 'profile/profileContactDataController', 'profile.contact_data'],
    'profile.experiences_and_skills' => ['/profile/experiences-and-skills', 'profile/profileExperiencesAndSkillsController', 'profile.experiences_and_skills'],
    'profile.additional_data' => ['/profile/additional-data', 'profile/profileAdditionalDataController', 'profile.additional_data'],
    'profile.education' => ['/profile/education', 'profile/profileEducationController', 'profile.education'],
    'profile.contracts' => ['/profile/contracts', 'profile/profileContractController', 'profile.contracts'],

    // Users Routes
    'users' => ['users', 'users/listUsersController', 'users.list'],
    'users.add' => ['users/add', 'users/addUserController', 'users.add'],
    'users.overview' => ['users/:id', 'users/overviewUserController', 'users.single.overview'],
    'users.edit' => ['users/:id/edit', 'users/editUserController', 'users.single.edit'],

    //Donors Routes
    'donors' => ['donors', 'donors/listDonorsController', 'donors.list'],
    'donors.add' => ['donors/add', 'donors/addDonorController', 'donors.add'],
    'donors.overview' => ['donors/:id', 'donors/overviewDonorController', 'donors.single.overview'],
    'donors.edit' => ['donors/:id/edit', 'donors/editDonorController', 'donors.single.edit'],

    /////////////////////// Places /////////////////////////
    'places' => ['places', 'places/listPlacesController', 'places.list'],
    'places.add' => ['places/add', 'places/addPlaceController', 'places.add'],
    'places.overview' => ['places/:id', 'places/overviewPlaceController', 'places.single.overview'],
    'places.edit' => ['places/:id/edit', 'places/editPlaceController', 'places.single.edit'],

    //Member Routes
    'members' => ['members', 'members/listMembersController', 'members.list'],
    'members.add' => ['members/add', 'members/addMemberController', 'members.add'],
    'members.overview' => ['members/:id', 'members/overviewMemberController', 'members.single.overview'],
    'members.contracts' => ['members/contracts/:id', 'members/contractMembersController', 'members.single.contracts'],
    'members.edit' => ['members/:id/edit', 'members/editMemberController', 'members.single.edit'],

    //Loan Requests
    'loan_requests' => ['loan-requests', 'loan_request/listLoanRequestController', 'loan_request.list'],
    'loan_requests.add' => ['loan-requests/add', 'loan_request/addLoanRequestController', 'loan_request.add'],
    'loan_requests.overview' => ['loan-requests/:id', 'loan_request/overviewLoanRequestController', 'loan_request.single.overview'],
    'loan_requests.edit' => ['loan-requests/:id/edit', 'loan_request/editLoanRequestController', 'loan_request.single.edit'],

    //Advance Payment Requests
    'advance_payment_requests' => ['advance-payment-requests', 'advance_payment_request/listAdvancePaymentRequestController', 'advance_payment_request.list'],
    'advance_payment_requests.add' => ['advance-payment-requests/add', 'advance_payment_request/addAdvancePaymentRequestController', 'advance_payment_request.add'],
    'advance_payment_requests.overview' => ['advance-payment-requests/:id', 'advance_payment_request/overviewAdvancePaymentRequestController', 'advance_payment_request.single.overview'],
    'advance_payment_requests.edit' => ['advance-payment-requests/:id/edit', 'advance_payment_request/editAdvancePaymentRequestController', 'advance_payment_request.single.edit'],

    //Travel Requests
    'travel_requests' => ['travel-requests', 'travel_request/listTravelRequestController', 'travel_request.list'],
    'travel_requests.add' => ['travel-requests/add', 'travel_request/addTravelRequestController', 'travel_request.add'],
    'travel_requests.overview' => ['travel-requests/:id', 'travel_request/overviewTravelRequestController', 'travel_request.single.overview'],
    'travel_requests.edit' => ['travel-requests/:id/edit', 'travel_request/editTravelRequestController', 'travel_request.single.edit'],

    //User Family Members
    'user_family_members' => ['user-family-members', 'user_family_member/listUserFamilyMemberController', 'user_family_member.list'],
    'user_family_members.add' => ['user-family-members/add', 'user_family_member/addUserFamilyMemberController', 'user_family_member.add'],
    'user_family_members.overview' => ['user-family-members/:id', 'user_family_member/overviewUserFamilyMemberController', 'user_family_member.single.overview'],
    'user_family_members.edit' => ['user-family-members/:id/edit', 'user_family_member/editUserFamilyMemberController', 'user_family_member.single.edit'],

    //User Contracts
    'user_contracts' => ['user-contracts', 'user_contract/listUserContractController', 'user_contract.list'],
    'user_contracts.add' => ['user-contracts/add/', 'user_contract/addUserContractController', 'user_contract.add'],
    'user_contracts.overview' => ['user-contracts/:id', 'user_contract/overviewUserContractController', 'user_contract.single.overview'],
    'user_contracts.edit' => ['user-contracts/:id/edit', 'user_contract/editUserContractController', 'user_contract.single.edit'],

    //User Sections
    'user_sections' => ['user-sections', 'user_section/listUserSectionController', 'user_section.list'],
    'user_sections.add' => ['user-sections/add', 'user_section/addUserSectionController', 'user_section.add'],
    'user_sections.overview' => ['user-sections/:id', 'user_section/overviewUserSectionController', 'user_section.single.overview'],
    'user_sections.edit' => ['user-sections/:id/edit', 'user_section/editUserSectionController', 'user_section.single.edit'],

    //User Work Experience
    'user_work_experiences' => ['user-work-experiences', 'user_work_experience/listUserWorkExperienceController', 'user_work_experience.list'],
    'user_work_experiences.add' => ['user-work-experiences/add', 'user_work_experience/addUserWorkExperienceController', 'user_work_experience.add'],
    'user_work_experiences.overview' => ['user-work-experiences/:id', 'user_work_experience/overviewUserWorkExperienceController', 'user_work_experience.single.overview'],
    'user_work_experiences.edit' => ['user-work-experiences/:id/edit', 'user_work_experience/editUserWorkExperienceController', 'user_work_experience.single.edit'],

    //User Skills
    'user_skills' => ['user-skills', 'user_skill/listUserSkillController', 'user_skill.list'],
    'user_skills.add' => ['user-skills/add', 'user_skill/addUserSkillController', 'user_skill.add'],
    'user_skills.overview' => ['user-skills/:id', 'user_skill/overviewUserSkillController', 'user_skill.single.overview'],
    'user_skills.edit' => ['user-skills/:id/edit', 'user_skill/editUserSkillController', 'user_skill.single.edit'],

    //Team Offices
    'team_offices' => ['team-offices', 'team_office/listTeamOfficeController', 'team_office.list'],
    'team_offices.add' => ['team-offices/add', 'team_office/addTeamOfficeController', 'team_office.add'],
    'team_offices.overview' => ['team-offices/:id', 'team_office/overviewTeamOfficeController', 'team_office.single.overview'],
    'team_offices.edit' => ['team-offices/:id/edit', 'team_office/editTeamOfficeController', 'team_office.single.edit'],

    //Job Titles
    'job_titles' => ['job-titles', 'job_title/listJobTitleController', 'job_title.list'],
    'job_titles.add' => ['job-titles/add', 'job_title/addJobTitleController', 'job_title.add'],
    'job_titles.overview' => ['job-titles/:id', 'job_title/overviewJobTitleController', 'job_title.single.overview'],
    'job_titles.edit' => ['job-titles/:id/edit', 'job_title/editJobTitleController', 'job_title.single.edit'],

];
