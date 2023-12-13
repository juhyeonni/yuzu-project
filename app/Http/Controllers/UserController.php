<?php

namespace App\Http\Controllers;

use App\Repositories\Eloquent\GameScoreRepository;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
  public function __construct(
    protected UserRepository $userRepository,
    protected GameScoreRepository $gameScoreRepository
  ) {
  }

  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    //
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   */
  public function show(string $username)
  {
    $user = $this->userRepository->findByUsername($username);
    $rank = $this->gameScoreRepository->rankingByUserId($user->id);

    return view("(user).profile", ["user" => $user, "rank" => $rank]);
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //
  }
}
