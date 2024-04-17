<?php

return [
    "1" => [
        "question" => "what is your profession?",
        "answer_type" => "dropdown",
        "explanation" => "",
        "related_questions" => [
        ],
        "contains_related" => false,
        "options" => [
            [
                "value" => "bsfi_industry_employee",
                "key" => "BSFI industry employee"
            ],
            [
                "value" => "private_corporate_sector_employee",
                "key" => "private/corporate sector employee"
            ],
            [
                "value" => "hr_professional",
                "key" => "HR Professional"
            ],
            [
                "value" => "freelancer",
                "key" => "Freelancer"
            ],
            [
                "value" => "direct_selling_agent",
                "key" => "Direct Selling Agent(DSA)"
            ],
            [
                "value" => "insurance_advisor_agent",
                "key" => "Insurance Advisor/Agent"
            ],
            [
                "value" => "mutual_fund_advisor",
                "key" => "Mutual Fund Advisor"
            ],
            [
                "value" => "wealth_advisor",
                "key" => "Wealth Advisor"
            ],
            [
                "value" => "real_estate_advisor",
                "key" => "Real Estate Advisor"
            ],
            [
                "value" => "chartered_accountant",
                "key" => "Chartered Accountant"
            ],
            [
                "value" => "company_secretary",
                "key" => "Company Secretary"
            ],
            [
                "value" => "accountant",
                "key" => "Accountant"
            ],
            [
                "value" => "architect_desginer",
                "key" => "Architect/Desginer"
            ],
            [
                "value" => "doctor",
                "key" => "Doctor"
            ],
            [
                "value" => "digital_marketer",
                "key" => "Digital Marketer"
            ],
            [
                "value" => "business_development_sales",
                "key" => "Business Development/sales"
            ],
            [
                "value" => "student",
                "key" => "Student"
            ],
            [
                "value" => "homemaker",
                "key" => "Homemaker"
            ],
            [
                "value" => "teaching_and_education",
                "key" => "Teaching & Education"
            ],
            [
                "value" => "medical_representative",
                "key" => "Medical Representative"
            ],
            [
                "value" => "business_and_trade",
                "key" => "Business & Trade"
            ],
            [
                "value" => "other",
                "key" => "Other"
            ]
        ]
    ],
    "2" => [
        "question" => "Employement Type?",
        "answer_type" => "dropdown",
        "explanation" => "",
        "related_questions" => [],
        "contains_related" => false,
        "options" => [
            [
                "value" => "salaried",
                "key" => "Salaried"
            ],
            [
                "value" => "self_employed",
                "key" => "Self-Employed"
            ],
            [
                "value" => "retired",
                "key" => "Retired"
            ],
            [
                "value" => "unemployed",
                "key" => "Unemployed"
            ],
            [
                "value" => "part-time_freelancer",
                "key" => "Part-time/Freelancer"
            ]
        ]
    ],
    "3" => [
        "question" => "Your Current Employer Name?",
        "answer_type" => "descriptive",
        "explanation" => "",
        "related_questions" => [],
        "contains_related" => false
    ],
    "4" => [
        "question" => "Total Experience?",
        "answer_type" => "descriptive",
        "explanation" => "",
        "options" => [],
        "related_questions" => [],
        "contains_related" => false
    ],

    "5" => [
        "question" => "Does any member of your immediate family is in the role of product, credit or sales in Banking & Financial Services?",
        "answer_type" => "radio",
        "explanation" => "",
        "options" => [
            [
                "value" => "yes",
                "label" => "Yes"
            ],
            [
                "value" => "no",
                "label" => "No"
            ]
        ],
        "related_questions" => [],
        "contains_related" => false
    ],
    "6" => [
        "question" => "Have you previously worked in financial Industry?",
        "answer_type" => "radio",
        "explanation" => "",
        "options" => [
            [
                "value" => "yes",
                "label" => "Yes"
            ],
            [
                "value" => "no",
                "label" => "No"
            ]
        ],
        "related_questions" => [],
        /*"related_questions" => [
            [
                "yes" => [
                    "1" => [
                        "question" => "what was your role and position?",
                        "answer_type" => "descriptive",
                        "explanation" => "",
                        "related_questions" => [],
                        "contains_related" => false
                    ],
                    "2" => [
                        "question" => "How many years have your worked in the industry?",
                        "answer_type" => "descriptive",
                        "explanation" => "",
                        "related_questions" => [],
                        "contains_related" => false
                    ],
                    "3" => [
                        "question" => "How many years since your are not working in the industry? ",
                        "answer_type" => "descriptive",
                        "explanation" => "",
                        "related_questions" => [],
                        "contains_related" => false
                    ],
                    "4" => [
                        "question" => "Have you worked as an agent, broker in financial sector? ",
                        "answer_type" => "descriptive",
                        "explanation" => "",
                        "related_questions" => [],
                        "contains_related" => false
                    ],
                ],
                "no" => [
                ]
            ]

        ],*/
        "contains_related" => true
    ]/*,
    "7" => [
        "question" => "Are you or any direct member of your family works in Politics or Government? ",
        "answer_type" => "radio",
        "explanation" => "",
        "options" => [
            [
                "value" => "yes",
                "label" => "Yes"
            ],
            [
                "value" => "no",
                "label" => "No"
            ]
        ],
        "related_questions" => [],
        "contains_related" => false
    ],
    */
];
