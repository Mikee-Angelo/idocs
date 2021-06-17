<?php

return [
    'admin-user' => [
        'title' => 'Users',

        'actions' => [
            'index' => 'Users',
            'create' => 'New User',
            'edit' => 'Edit :name',
            'edit_profile' => 'Edit Profile',
            'edit_password' => 'Edit Password',
        ],

        'columns' => [
            'id' => 'ID',
            'school_id' => 'Campus Name',
            'last_login_at' => 'Last login',
            'first_name' => 'First name',
            'last_name' => 'Last name',
            'email' => 'Email',
            'password' => 'Password',
            'password_repeat' => 'Password Confirmation',
            'activated' => 'Activated',
            'forbidden' => 'Forbidden',
            'language' => 'Language',
                
            //Belongs to many relations
            'roles' => 'Roles',
                
        ],
    ],

    'gad-plan' => [
        'title' => 'Gad Plans and Budget',

        'actions' => [
            'index' => 'Gad Plans and Budget',
            'create' => 'New Gad Plan',
            'edit' => 'Edit :name',
            'create_gad' => 'Create Gad Plan first'
        ],

        'columns' => [
            'id' => 'ID',
            'role_id' => 'Role',
            'model_type' => 'Model type',
            'model_id' => 'Campus Name',
            'created_at' => 'Date Created',
            'status' => 'Status',
            
        ],
    ],

    'gad-plan-list' => [
        'title' => 'Gad Plan and Budget Lists',

        'actions' => [
            'index' => 'Gad Plans and Budget Lists',
            'create' => 'Add GAD Plan',
            'edit' => 'Edit :name',
            'accept' => 'Accept',
            'decline' => 'Decline',
            'submit' => 'Submit',
        ],

        'columns' => [
            'id' => 'ID',
            'gad_issue_mandate' => 'Gender Issue and/or GAD Mandate',
            'cause_of_issue' => 'Cause of the Gender Issue',
            'gad_statement_objective' => 'GAD Result Statement/GAD Objective',
            'relevant_agencies' => 'Relevant Agencies',
            'gad_activity' => 'GAD Activity',
            'indicator_target' => 'Output Performance Indicator and Target',
            'budget_requirement' => 'Budgetary Requirement',
            'budget_source' => 'Source of Budget',
            'responsible_unit' => 'Responsible Unit',
            'status' => 'Status',    
        ],
    ],

    'school' => [
        'title' => 'Campus/College',

        'actions' => [
            'index' => 'Campus/College',
            'create' => 'Add Campus/College',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'name' => 'Campus Name', 
            'admin_users_id' => 'Created By', 
            'status' => 'Status',
            'address' => 'Complete Address'
        ],
    ],

    'relevant-agency' => [
        'title' => 'Relevant Agencies',

        'actions' => [
            'index' => 'Relevant Agencies',
            'create' => 'Add relevant agencies',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'name' => 'Agency Name', 
        ],
    ],

    'source-of-budget' => [
        'title' => 'Source of Budget',

        'actions' => [
            'index' => 'Source of Budget',
            'create' => 'Add source',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'name' => 'Source Name', 
        ],
    ],

    'proposal' => [
        'title' => 'Proposals',

        'actions' => [
            'index' => 'Proposals',
            'create' => 'Add proposals',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'gad_plans_id' => 'GAD',
            'letter_body' => 'Letter Body', 
            'proposal_body' => 'Proposal Body', 
        ],
    ],
    
    'liquidation' => [
        'title' => 'Liquidations',

        'actions' => [
            'index' => 'Liquidations',
            'create' => 'Add liquidations',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'purpose' => 'Purpose',
            'status' => 'Status', 
            'proposal_body' => 'Proposal Body', 
        ],
    ],

    'supplier' => [
        'title' => 'Suppliers',

        'actions' => [
            'index' => 'Suppliers',
            'create' => 'Add suppliers',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'name' => 'Supplier Name',
            'added_by' => 'Added By',
        ],
    ],

    'unit' => [
        'title' => 'Units',

        'actions' => [
            'index' => 'Units',
            'create' => 'Add Unit',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'name' => 'Unit Name',
            'added_by' => 'Added By',
        ],
    ],

    'reimbursement' => [
        'title' => 'Reimbursements',

        'actions' => [
            'index' => 'Reimbursements',
            'create' => 'Add Reimbursements',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'admin_user_id' => 'Created By',
            'letter_body' => 'Letter Body',
            'status' => 'Status',
        ],
    ],

    'event-type' => [
        'title' => 'Event Types',

        'actions' => [
            'index' => 'Event Types',
            'create' => 'Add Event Types',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'name' => 'Event Type Name',
        ],
    ],

    'announcement' => [
        'title' => 'Announcements',

        'actions' => [
            'index' => 'Announcements',
            'create' => 'Add announcements',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'name' => 'Event Type Name',
            'header_img' => 'Header Image',
            'title' => 'Title',
            'description' => 'Description',
            'url' => 'Meeting Url   ',
            'event_type_id' => 'Event Type',
            'starts_at' => 'Starts At',
            'ends_at' => 'Ends At',
            'created_by' => 'Created By',
            'created_at' => 'Created At'
        ],
    ],

    'calendar' => [
        'title' => 'Calendar',

        'actions' => [
            'index' => 'Calendar',
            'create' => 'Add announcements',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'name' => 'Event Type Name',
            'header_img' => 'Header Image',
            'title' => 'Title',
            'description' => 'Description',
            'url' => 'Meeting Url   ',
            'event_type_id' => 'Event Type',
            'starts_at' => 'Starts At',
            'ends_at' => 'Ends At',
            'created_by' => 'Created By',
            'created_at' => 'Created At'
        ],
    ],

    // Do not delete me :) I'm used for auto-generation
];