<?php

return [

    'development' => [
        [
            'type' => 'text',
            'name' => 'name',
            'placeholder' => 'Employee name',
            'required' => true,
        ],
        [
            'type' => 'email',
            'name' => 'email',
            'placeholder' => 'Employee Email',
            'required' => true,
        ],
        [
            'type' => 'text',
            'name' => 'phone',
            'placeholder' => 'Employee Phone',
            'required' => true,
        ],
        [
            'type' => 'text',
            'name' => 'address',
            'placeholder' => 'Employee Address',
            'required' => true,
        ],
        [
            'type' => 'select',
            'name' => 'department_id',
            'label' => 'Select Department',
            'options' => 'departments',
            'optionLabel' => 'name',
            'required' => true,
        ],
        [
            'type' => 'multiselect',
            'name' => 'project_ids[]',
            'label' => 'Select Projects',
            'options' => 'projects',
            'optionLabel' => 'title',
            'required' => false,
        ],
        [
            'type' => 'file',
            'name' => 'image',
            'placeholder' => 'Employee Image',
            'required' => false,
        ],
    ],

    'marketing' => [
        [
            'type' => 'text',
            'name' => 'name',
            'placeholder' => 'Employee name',
            'required' => true,
        ],
        [
            'type' => 'email',
            'name' => 'email',
            'placeholder' => 'Employee Email',
            'required' => true,
        ],
        [
            'type' => 'text',
            'name' => 'phone',
            'placeholder' => 'Employee Phone',
            'required' => true,
        ],
        [
            'type' => 'text',
            'name' => 'address',
            'placeholder' => 'Employee Address',
            'required' => true,
        ],
        [
            'type' => 'file',
            'name' => 'image',
            'placeholder' => 'Employee Image',
            'required' => false,
        ],
    ],

    'project' => [
        [
            'type' => 'text',
            'name' => 'title',
            'placeholder' => 'Project title',
            'required' => true,
        ],
        [
            'type' => 'text',
            'name' => 'description',
            'placeholder' => 'Project description',
            'required' => true,
        ],
        [
            'type' => 'date',
            'name' => 'start_date',
            'placeholder' => 'Start date',
            'required' => true,
        ],
        [
            'type' => 'date',
            'name' => 'end_date',
            'placeholder' => 'End date',
            'required' => true,
        ],
    ],
];
