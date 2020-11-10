<?php

namespace App\Models;

use App\Http\Resources\PerformaceScoreResource;
use App\Traits\SendMailNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CslgCalculation extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function bcp()
    {
        return $this->belongsTo(Bcp::class);
    }

    public static function calculate(PerformanceScore $performanceScore, WspReporting $reporting)
    {
        $bcp = $performanceScore->bcp;
        $monthly_grant_multiplier = $bcp->mgms()
            ->where('month', $performanceScore->month)
            ->where('year', $performanceScore->year)
            ->first();

        $score = json_encode(new PerformaceScoreResource($performanceScore));
        $score = json_decode($score);
        $score = intval($score->total);
        $adjusted_score = ($score >= 70) ? 100 : $score;

        $covid_costs = collect(json_decode($reporting->status_of_covid_implementation))->sum('cost');

        $gross_clsg = $covid_costs + (intval($reporting->revenue) * $adjusted_score / 100);
        info("clsg",[
            'monthly_grant_multiplier' => $monthly_grant_multiplier->amount,
            'actual_performance_score' => $score,
            'adjusted_performance_score' => $adjusted_score,
            'gross_clsg' => $gross_clsg,
            'fixed_grant' => $covid_costs,
            'revenue' => $reporting->revenue,
            'month' => $performanceScore->month,
            'year' => $performanceScore->year,
            'bcp_id' => $performanceScore->bcp_id,
            'status' => 'Pending'
        ]);

        $clsg = self::query()->where('month', $performanceScore->month)
            ->where('year', $performanceScore->year)
            ->where('bcp_id', $performanceScore->bcp_id)
            ->first();

        if($clsg) return;

        $clsg = self::create([
            'monthly_grant_multiplier' => $monthly_grant_multiplier->amount,
            'actual_performance_score' => $score,
            'adjusted_performance_score' => $adjusted_score,
            'gross_clsg' => $gross_clsg,
            'fixed_grant' => $covid_costs,
            'revenue' => $reporting->revenue,
            'month' => $performanceScore->month,
            'year' => $performanceScore->year,
            'bcp_id' => $performanceScore->bcp_id,
            'status' => 'Pending'
        ]);

        $wsp = $bcp->wsp;

        SendMailNotification::created($wsp,
            route('cslg-calculation.show', $clsg->id),
            'CLSG Calculation Report Ready',
            $wsp->name . ' CLSG Calculation report for ' . \DateTime::createFromFormat("!m", $reporting->month)->format("F") .
            ' ' . $reporting->year. ' is ready'
        );
    }
}
