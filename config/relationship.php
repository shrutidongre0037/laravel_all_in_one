<?php
return [
    'modules' => [

        'Tenant' => [
            'relations' => [
                'users' => [
                    'type' => 'hasMany',
                    'model' => 'User',
                    'foreignKey' => 'tenant_id',
                    'localKey' => 'id',
                ]
            ]
        ],

        'Department' => [
            'relations' => [
                'developmentLinks' => [ // optional: link model if you want
                    'type' => 'hasMany',
                    'model' => 'DepartmentDevelopment',
                    'foreignKey' => 'department_id',
                    'localKey' => 'id',
                ],
                'developments' => [
                    'type' => 'hasManyThrough',
                    'model' => 'Development',
                    'through' => 'DepartmentDevelopment',
                    'firstKey' => 'id',              // department.id
                    'secondKey' => 'department_id',  // department_development.department_id
                    'localKey' => 'development_id',  // department_development.development_id
                    'secondLocalKey' => 'id',        // development.id
                ]
            ]
        ],

        'Development' => [
            'relations' => [
                'departmentLink' => [
                    'type' => 'hasOne',
                    'model' => 'DepartmentDevelopment',
                    'foreignKey' => 'development_id',
                    'localKey' => 'id',
                ],
                'projects' => [
                    'type' => 'belongsToMany',
                    'model' => 'Project',
                    'table' => 'development_project', // default naming suggestion
                    'foreignPivotKey' => 'development_id',
                    'relatedPivotKey' => 'project_id',
                ],
                'profileLink' => [
                    'type' => 'hasOne',
                    'model' => 'DevelopmentProfile',
                    'foreignKey' => 'development_id',
                    'localKey' => 'id',
                ],
                
            ]
        ],

        'Profile' => [
            'relations' => [
                'developmentLink' => [
                    'type' => 'hasOne',
                    'model' => 'DevelopmentProfile',
                    'foreignKey' => 'profile_id',
                    'localKey' => 'id',
                ],
            ]
        ],

        'Project' => [
            'relations' => [
                'developments' => [
                    'type' => 'belongsToMany',
                    'model' => 'Development',
                    'table' => 'development_project', // same pivot table
                    'foreignPivotKey' => 'project_id',
                    'relatedPivotKey' => 'development_id',
                ]
            ]
        ],

        'DevelopmentProfile' => [
            'relations' => [
                'development' => [
                    'type' => 'belongsTo',
                    'model' => 'Development',
                    'foreignKey' => 'development_id',
                    'ownerKey' => 'id',
                ],
                'profile' => [
                    'type' => 'belongsTo',
                    'model' => 'Profile',
                    'foreignKey' => 'profile_id',
                    'ownerKey' => 'id',
                ],
            ]
        ]

    ]
];
