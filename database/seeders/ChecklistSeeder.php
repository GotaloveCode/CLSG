<?php

namespace Database\Seeders;

use App\Models\BcpChecklist;
use Illuminate\Database\Seeder;

class ChecklistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        BcpChecklist::create(['name' => 'Identify a BCP coordinator and/or team with defined roles and responsibilities', 'type' => 'Essential Operations']);
        BcpChecklist::create(['name' => 'Identify critical operational functions that must be maintained during the pandemic period', 'type' => 'Essential Operations']);
        BcpChecklist::create(['name' => 'Identify essential personnel functions and critical inputs needed to maintain operations, including locations where they may be needed during a pandemic. Ensure there is redundancy in terms of personnel (cross-training), materials (chemical suppliers, equipment suppliers, etc.), communication (phones, radios, etc.), information technology, and power (electric, generators). Establish contingency agreements with other utilities where feasible', 'type' => 'Essential Operations']);
        BcpChecklist::create(['name' => 'Cross train employees to provide backups for critical positions. Train and prepare an ancillary workforce (e.g. contractors)', 'type' => 'Essential Operations']);
        BcpChecklist::create(['name' => 'Develop and plan for scenarios likely to result in an increase or decrease in demand on your facilities during the COVID-19 pandemic (Loss of tourism, consumers at home instead of work, etc.)', 'type' => 'Essential Operations']);
        BcpChecklist::create(['name' => 'Determine the potential impact of the pandemic on utility-related travel (e.g. quarantines, border closures that limit availability of chemicals), including suppliers who make deliveries. Encourage suppliers to develop their own pandemic BCPs', 'type' => 'Essential Operations']);
        BcpChecklist::create(['name' => 'Evaluate impact of pandemic on billing and revenue collection and develop plans to ensure the utility maintains an acceptable level of revenue collections', 'type' => 'Essential Operations']);
        BcpChecklist::create(['name' => 'Evaluate impact of pandemic on NRW reduction activities and develop plans to ensure the maintains NRW levels at least pre-COVID levels', 'type' => 'Essential Operations']);
        BcpChecklist::create(['name' => 'Establish an emergency communications plan and revise it periodically. The plan should include identification of key contacts (with back-ups), chain of communications (including suppliers and key customers), and processes for tracking and communicating utility operational status and status of employees', 'type' => 'Essential Operations']);
        BcpChecklist::create(['name' => 'Implement an exercise/drill to test your plan and revise it periodically', 'type' => 'Essential Operations']);
        BcpChecklist::create(['name' => 'Identify key customers and customers with special needs (such as hospitals, vulnerable communities in low-income areas) and ensure water services are provided', 'type' => 'Vulnerable Customers']);
        BcpChecklist::create(['name' => 'Implement COVID-19 emergency response interventions for vulnerable customers', 'type' => 'Vulnerable Customers']);
        BcpChecklist::create(['name' => 'Forecast and allow for employee absences during a pandemic due to factors such as personal illness, family member illness, community containment measures and quarantines, school and/or business closures, and public transportation closures', 'type' => 'Staff Health Protection']);
        BcpChecklist::create(['name' => 'Implement guidelines to limit the frequency and type of face-to-face contact (e.g. handshaking, meetings, office layout, shared workstations) among employees and between employees and customers', 'type' => 'Staff Health Protection']);
        BcpChecklist::create(['name' => 'Evaluate employee access to and availability of healthcare services during a pandemic, and improve services as needed', 'type' => 'Staff Health Protection']);
        BcpChecklist::create(['name' => 'Establish policies for employee attendance, sick-leave absences and compensation unique to a pandemic (e.g. non-punitive, liberal leave), including policies on when a previously ill person is no longer infectious and can return to work after illness', 'type' => 'Staff Health Protection']);
        BcpChecklist::create(['name' => 'Establish policies for ﬂexible worksite (e.g. telecommuting) and ﬂexible work hours (e.g. staggered shifts)', 'type' => 'Staff Health Protection']);
        BcpChecklist::create(['name' => 'Establish policies for preventing pandemic spread at the worksite (e.g. promoting respiratory hygiene/cough etiquette, sanitizer stations, disinfecting work areas and break rooms, and prompt exclusion of people with symptoms)', 'type' => 'Staff Health Protection']);
        BcpChecklist::create(['name' => 'Establish policies for employees who have been exposed to pandemic are suspected to be ill, or become ill at the worksite (e.g. infection control response, immediate mandatory sick leave)', 'type' => 'Staff Health Protection']);
        BcpChecklist::create(['name' => 'Establish policies for teleconferencing and videoconferencing to limit face to face contact', 'type' => 'Staff Health Protection']);
        BcpChecklist::create(['name' => 'Provide enough and accessible infection control supplies (e.g. alcohol sanitizer stations, tissues, facial masks) at all work-related locations', 'type' => 'Staff Health Protection']);
        BcpChecklist::create(['name' => 'Enhance communications and information technology infrastructures as needed to support employee home-based work and remote customer access', 'type' => 'Staff Health Protection']);
        BcpChecklist::create(['name' => 'Ensure availability of medical consultation and advice for emergency response', 'type' => 'Staff Health Protection']);
        BcpChecklist::create(['name' => 'Develop and disseminate materials covering pandemic fundamentals (e.g. signs and symptoms, modes of transmission),personal and family protection and response strategies (e.g. hand hygiene, use of masks, coughing/sneezing etiquette, contingency plans)', 'type' => 'Communication']);
        BcpChecklist::create(['name' => 'Ensure that communications are culturally and linguistically appropriate', 'type' => 'Communication']);
        BcpChecklist::create(['name' => 'Disseminate information to employees about your pandemic preparedness and response plan', 'type' => 'Communication']);
    }
}
