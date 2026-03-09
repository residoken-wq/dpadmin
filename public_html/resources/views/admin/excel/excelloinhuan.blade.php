<meta charset="UTF-8">
<table class="table table-sm  table-bordered table-striped dataTable">
    <thead>
    <tr>
        <th>
            @if($search['filter']=='1')
                Ngay
            @endif
            @if($search['filter']=='2')
                Thang
            @endif
            @if($search[' filter']=='3')
                Nam
            @endif
        </th>
        @if($search['filter']=='2')
            <th>
                Nam
            </th>
        @endif
        <th> Tien Chi</th>
        <th> Tien Thu</th>
        <th> Loi Nhuan</th>
        <th> Tien Lo</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($data_list as $list):?>

    <tr>
        <td>
            @if($search['filter']=='1')
                <?php $value = Date("d-m-Y", strtotime($list['my_date'])); ?>
                {{Date("d-m-Y",strtotime($list['my_date']))}}
            @endif
            @if($search['filter']=='2')
                <?php $value = Date("m", strtotime($list['my_date'])); ?>
                {{Date("m",strtotime($list['my_date']))}}

            @endif
            @if($search['filter']=='3')
                <?php $value = Date("Y", strtotime($list['my_date'])); ?>
                {{Date("Y",strtotime($list['my_date']))}}
            @endif
        </td>
        @if($search['filter']=='2')
            <td>

                {{Date("Y",strtotime($list['my_date']))}}
            </td>
        @endif
        <?php
        $thu = (int)$list->TongThu($search['filter'])['total'];
        $chi = (int)$list->TongChi($search['filter'])['total'];
        ?>
        <td> {{$chi}}

        </td>
        <td>
            {{$thu}}

        </td>
        <td>

            @if($thu > $chi)

                {{ ($thu-$chi)}}
            @endif
        </td>
        <td>
            @if($chi > $thu)
                {{ ($chi-$thu)}}
            @endif
        </td>
    </tr>

    <?php endforeach;?>

    </tbody>
</table>

