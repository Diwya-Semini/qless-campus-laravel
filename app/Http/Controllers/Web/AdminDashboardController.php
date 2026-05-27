<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Canteen;
use Illuminate\Http\Request;
use App\Models\User;

use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    // 1. Render all campus locations in the grid view
    public function index()
    {
        $canteens = Canteen::all()->map(function ($canteen) {
            // Fallback protection: if the admin or manager manually turned off the branch, force it closed
            if ($canteen->is_open == 0) {
                $canteen->calculated_status = 'CLOSED';
                return $canteen;
            }

            try {
                // Parse operational range configurations (e.g., "7:00 AM - 6:00 PM")
                $hours = explode('-', $canteen->operating_hours);
                if (count($hours) === 2) {
                    $openTime = Carbon::parse(trim($hours[0]));
                    $closeTime = Carbon::parse(trim($hours[1]));
                    $currentTime = Carbon::now();

                    // Check if the current clock sits perfectly inside active shifts
                    if ($currentTime->between($openTime, $closeTime)) {
                        $canteen->calculated_status = 'OPEN';
                    } else {
                        $canteen->calculated_status = 'CLOSED';
                    }
                } else {
                    $canteen->calculated_status = 'OPEN'; // Fallback if format is customized
                }
            } catch (\Exception $e) {
                $canteen->calculated_status = 'OPEN'; // Safeguard fallbacks
            }

            return $canteen;
        });

        return view('admin.dashboard', compact('canteens'));
    }

    // 2. Show the "Deploy Canteen" deployment form layout view
    // 1. Show the deployment form alongside existing tenant inventories
    public function create()
    {
        $canteens = Canteen::all(); // Fetch all canteens to populate the list view table
        return view('admin.deploy-canteen', compact('canteens'));
    }

    // 2. Perform a hard cancellation or removal of a canteen tenant entry
    public function destroyCanteen($id)
    {
        $canteen = Canteen::findOrFail($id);
        
        // This will safely drop the canteen and cascade delete linked items or records
        $canteen->delete();

        return redirect()->route('admin.canteens.create')->with('success', 'Canteen subscription canceled and infrastructure decommissioned successfully.');
    }

    // 3. Store a brand new campus tenant inside the database
    public function store(Request $request)
    {
        // 1. Validate incoming data (Must match form input names)
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'location'        => 'required|string|max:255',
            'operating_hours' => 'required|string|max:255',
            'is_open'         => 'required|boolean'
        ]);

    // 2. Create the record in your canteens table
    Canteen::create($validated);

    // 3. Redirect back to the creation panel with a success banner!
    return redirect()->route('admin.canteens.create')->with('success', 'New Campus Canteen Deployed Successfully!');
    }

    // 1. List Pending Managers & Active Platform Records
    public function platformManagers()
    {
        $pendingManagers = User::where('role', 'manager')->where('approval_status', 'pending')->with('canteen')->get();
        $activeManagers = User::where('role', 'manager')->where('approval_status', 'approved')->with('canteen')->get();
        
        return view('admin.platform-managers', compact('pendingManagers', 'activeManagers'));
    }

    // 2. Action Endpoint to Approve Manager Accounts
    public function approveManager($id)
    {
        $manager = User::findOrFail($id);
        $manager->update(['approval_status' => 'approved']);
        
        return redirect()->back()->with('success', "Manager {$manager->name} successfully approved!");
    }

    // 3. Action Endpoint to Reject Manager Accounts
    public function rejectManager($id)
    {
        $manager = User::findOrFail($id);
        $manager->update(['approval_status' => 'rejected']);
        
        return redirect()->back()->with('error', "Registration for {$manager->name} was declined.");
    }

    // 4. Show the Admin Form to Directly Register a Student
    public function createStudent()
    {
        return view('admin.create-student');
    }

    // 5. Securely Store the Admin-Created Student Profile
    public function storeStudent(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => 'student',
            'approval_status' => 'approved' // Automatically activated
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Student account provisioned cleanly!');
    }
        }
