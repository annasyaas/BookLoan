<?php

namespace App\Http\Controllers;

use App\Http\Requests\MemberRequest;
use App\Models\Member;
use App\Models\Recommendation;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $members = Member::all();
        return view('dashboard.members.index', [
            'members' => $members
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.members.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MemberRequest $request)
    {
        $datas = $request->validated();

        Member::create($datas);

        return redirect('/member')->with('success', 'Data Member berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function show(Member $member)
    {
        $rec = Recommendation::with('book')->where('member_id', $member->id)->get();

        if($rec->isNotEmpty()) {
            $items = $rec->where('method', 1);
            $users = $rec->where('method', 0);
            return view('dashboard.members.show', [
                'items' => $items,
                'users' => $users
            ]);
        } else {
            return redirect()->route('member.index')->with('failed', 'Member belum meminjam minimal 5 buku.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function edit(Member $member)
    {
        return view('dashboard.members.edit', [
            'member' => $member
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function update(MemberRequest $request, Member $member)
    {
        $item = $request->validated();

        Member::where('id', $member->id)->update($item);

        return redirect()->route('member.index')->with('success', 'Data Member berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function deleteData(Request $request)
    {
        Member::destroy($request['id']);

        return response()->json('berhasil', 200);
        
    }

    public function getMember()
    {
        $members = Member::orderBy('id', 'ASC')->get();
        $i = 1;
        foreach ($members as $member) {
            $member['number'] = $i++;
        }

        return response()->json($members, 200);
    }
}
