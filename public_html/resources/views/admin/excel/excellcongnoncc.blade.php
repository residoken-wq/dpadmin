<meta charset="UTF-8">
<table>
    <thead>
    <tr>
        <th>Ten NCC</th>
        <th>Cong No</th>
        <th>Tong So Phieu</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($data_list as $list)
        <tr>
            <td>
                {{ $list->Supplier()->name }}
            </td>
            <td><?php echo App\MrData::toPrice($list['tongcongno']); ?></td>
            <td><?php echo $list->count(); ?></td>
        </tr>
    @endforeach
    </tbody>
</table>
