<?php

declare(strict_types=1);

namespace App\Services;

use App\Constants\Icons;
use App\Repositories\Availability\AvailabilityEQRepository as Availability;
use App\Repositories\User\UserEQRepository as User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CalendarService
{
    protected User $User;

    protected Availability $Availability;

    protected Carbon $Carbon;

    protected Carbon $fistDayOfMonth;

    protected Carbon $nextMonth;

    protected Carbon $prevMonth;

    public function __construct()
    {
        $this->User = new User;
        $this->Availability = new Availability;

        // GETがあればGETからCarbonインスタンスを作成
        if (isset($_GET['ym'])) {
            $Carbon = new Carbon($_GET['ym']);
        } else {
            $Carbon = Carbon::now();
        }

        // クラス変数代入
        $this->Carbon = $Carbon;
        $this->firstDayOfMonth = $Carbon->copy()->firstOfMonth();
        $this->lastDayOfMonth = $Carbon->copy()->lastOfMonth();
        $this->prevMonth = $Carbon->copy()->subMonthsNoOverflow();
        $this->nextMonth = $Carbon->copy()->addMonthsNoOverflow();
    }

    /**
     * カレンダーデータ（HTML）を返却する.
     *
     * @return string
     */
    public function render()
    {
        $calendar = '';
        $calendar .= $this->getCalendarHeader();
        $calendar .= $this->getCalendarBody();
        return $calendar;
    }

    /**
     * @return Carbon $this->Carbon
     */
    public function getCurrentMonth(): Carbon
    {
        return $this->Carbon;
    }

    /**
     * @return Carbon $this->prevMonth
     */
    public function getPrevMonth(): Carbon
    {
        return $this->prevMonth;
    }

    /**
     * @return Carbon $this->prevMonth
     */
    public function getNextMonth(): Carbon
    {
        return $this->nextMonth;
    }

    /**
     * テーブルヘッダーHTML.
     *
     * @return string $header
     */
    private function getCalendarHeader(): string
    {
        $header = [];

        $header[] = '<div class="calendar">';
        $header[] = '<table class="table table-bordered">';
        $header[] = '<thead>';
        $header[] = '<tr>';
        $header[] = '<th>月</th>';
        $header[] = '<th>火</th>';
        $header[] = '<th>水</th>';
        $header[] = '<th>木</th>';
        $header[] = '<th>金</th>';
        $header[] = '<th>土</th>';
        $header[] = '<th>日</th>';
        $header[] = '</tr>';
        $header[] = '</head>';

        return implode($header);
    }

    /**
     * テーブルボディhtml.
     *
     * @return string $html
     */
    private function getCalendarBody(): string
    {
        $html = [];

        $html[] = '<tdoby>';
        $weeks = $this->getWeeks();

        foreach ($weeks as $week) {
            $html[] = '<tr>';

            foreach ($week as $day) {
                if ($day) {
                    $date = new Carbon($day);
                    $css = $this->getCss($date);
                    $html[] = '<td ' . $css . '>';
                    $html[] = $date->format('j');
                    $html[] = $this->generateLink($date);
                    $html[] = '</td>';
                } else {
                    $html[] = '<td></td>';
                }
            }
            $html[] = '</tr>';
        }
        $html[] = '</tbody>';
        $html[] = '</table>';
        $html[] = '</div>';

        return implode($html);
    }

    /**
     * CSS取得 class="~~"の文字列を返す.
     *
     * @param Carbon $date
     * @return string or null
     */
    private function getCss(Carbon $date): string
    {
        $css = [];

        // 今日と過去の日付は色を変える
        if ($date->isToday()) {
            $css[] = 'today';
        } elseif ($date->isPast()) {
            $css[] = 'past text-muted';
        }

        // 曜日ごとのCSS
        $css[] = strtolower($date->format('D'));

        return 'class="' . implode(' ', $css) . '"';
    }

    /**
     * リンクボタン取得.
     *
     * @param Carbon
     * @param Carbon $date
     * @return string $html
     */
    private function generateLink(Carbon $date): string
    {
        $emtpylink = '<div class="text-muted">' . Icons::SLASH . '</div>';

        $link = [];

        // 過去の日付 or 今日ならリンクなし
        if ($date->isPast() || $date->isToday()) {
            return $emtpylink;
        }

        // メンターは編集画面へのリンク
        $user = $this->User->getUserBySub(Auth::id());

        if ($user->is_mentor) {
            //時間設定の文字列作成
            $time = "<option value =''>" . ' ' . '</option>';

            for ($i = 0; $i <= 23; $i++) {
                $time = $time . '<option value =' . $i . ':00' . '>' . $i . ':00' . '</option>';
                $time = $time . '<option value =' . $i . ':30' . '>' . $i . ':30' . '</option>';
            }
            $link[] = '<div>';
            $link[] = '<a class="text-primary" href="#';
            $link[] = 'date' . $date->format('Ymd');
            $link[] = '" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="date' . $date->format('Ymd') . '">' . Icons::PLUS . '</a>';
            $link[] = '<div class="collapse" id="';
            $link[] = 'date' . $date->format('Ymd') . '">';
            $link[] = '<div class="card card-body ">';
            $link[] = '<div class ="start_time text-center"> 開始';
            $link[] = '<select name=' . 'start_' . $date->format('Ymd') . '>' . $time . '</select> </div> </br>';
            $link[] = '<div class ="end_time text-center"> 終了';
            $link[] = '<select name=' . 'end_' . $date->format('Ymd') . '>' . $time . '</select> </div>';
            $link[] = '</div>';
            $link[] = '</div>';
            $link[] = '</div>';
            return implode($link);
        }

        // メンティーはメンターの空きがあればリンクが見られる
        $availability = $this->Availability->getAvailabilityByMentorId($user->mentor_id);

        // TODO: 下記と同じ結果になるようにリポジトリとユーザーModelを実装
        // Availability::where('available_date', $date)->where('mentor_id', $user->mentor_id)->first();

        if ($availability === null) {
            return $emtpylink;
        }
        $link[] = '<div>';
        $link[] = '<a class="text-success" href="#';
        $link[] = $date->format('Y-m-d');
        $link[] = '" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapseExample">' . Icons::PLUS . '</a>';
        $link[] = '<div class="collapse" id="';
        $link[] = $date->format('Y-m-d') . "'";
        $link[] = '"</div>';
        $link[] = '</div>';
        return implode($link);
    }

    /**
     * 日付配列を週の配列に入れる.
     *
     * @return array $weeks
     */
    private function getWeeks(): array
    {
        $weeks = [];
        $tmpDay = $this->firstDayOfMonth->copy();

        // 月末までループ
        while ($tmpDay->lte($this->lastDayOfMonth)) {
            $weeks[] = $this->getDays($tmpDay);
            $tmpDay->addDay(7);
        }

        return $weeks;
    }

    /**
     * 日付文字列配列.
     * @param Carbon $date
     * @return array $days
     */
    private function getDays(Carbon $date): array
    {
        $tmpDay = $date->copy()->startOfWeek(); // 週の頭にセット

        // 週末までループ
        $endOfWeek = $date->copy()->endOfWeek();
        $days = [];
        while ($tmpDay->lte($endOfWeek)) {
            //前の月、もしくは後ろの月の場合は空文字
            if ($tmpDay->month !== $this->Carbon->month) {
                $days[] = '';
                $tmpDay->addDay(1);
                continue;
            }

            $days[] = $tmpDay->format('Y-m-d');

            $tmpDay->addDay(1);
        }
        return $days;
    }
}
