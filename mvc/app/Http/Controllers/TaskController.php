<?php

// Namespace declaration - this file belongs to the App\Http\Controllers namespace
// Controllers handle HTTP requests and coordinate between Models and Views
namespace App\Http\Controllers;

// Import the Task model to interact with the tasks table in the database
use App\Models\Task;
// Import Request for handling HTTP request data (form inputs, query parameters)
use Illuminate\Http\Request;
// Import Session for accessing user session data (to get current logged-in user's ID)
use Illuminate\Support\Facades\Session;

/**
 * TaskController handles all CRUD operations for tasks (Create, Read, Update, Delete)
 * Each task belongs to a specific user, so we filter tasks by user_id from the session
 */
class TaskController extends Controller
{
    /**
     * Display a listing of all tasks for the currently logged-in user.
     * This is the main tasks page that shows all tasks belonging to the current user.
     * 
     * @return \Illuminate\View\View - Returns the tasks index blade view with the tasks collection
     */
    public function index()
    {
        // Fetch all tasks from the database where user_id matches the logged-in user
        // Session::get('user_id') retrieves the current user's ID that was stored during login
        $tasks = Task::where('user_id', Session::get('user_id'))->get();
        
        // Pass the tasks to the view using compact() - equivalent to ['tasks' => $tasks]
        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new task.
     * This displays the form where users can enter a new task title.
     * 
     * @return \Illuminate\View\View - Returns the task creation form blade view
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created task in the database.
     * This handles the form submission from the create page.
     * 
     * @param Request $request - Contains the task title from the form
     * @return \Illuminate\Http\RedirectResponse - Redirects back to tasks list with success message
     */
    public function store(Request $request)
    {
        // Validate that title is provided and meets requirements:
        // - required: must be present
        // - string: must be a string
        // - max:255: cannot exceed 255 characters
        $request->validate([
            'title' => 'required|string|max:255'
        ]);

        // Create a new task in the database with:
        // - user_id: Links the task to the currently logged-in user (from session)
        // - title: The task title from the form input
        Task::create([
            'user_id' => Session::get('user_id'),
            'title' => $request->title
        ]);

        // Redirect to the tasks list page with a success flash message
        return redirect('/tasks')->with('success', 'Task created successfully');
    }

    /**
     * Display a specific task (not used in this application).
     * This would show a single task detail page, but we don't use it here.
     * 
     * @param string $id - The ID of the task to display
     */
    public function show(string $id)
    {
        // Not implemented - we're using the index page to show all tasks
    }

    /**
     * Show the form for editing an existing task.
     * This displays a pre-filled form with the current task data.
     * 
     * @param string $id - The ID of the task to edit
     * @return \Illuminate\View\View|\Illuminate\Http\Response - Returns edit form or 404 if not found
     */
    public function edit(string $id)
    {
        // Find the task by ID, but ONLY if it belongs to the current user
        // This prevents users from editing other users' tasks
        // firstOrFail() throws a 404 exception if no matching task is found
        $task = Task::where('id', $id)->where('user_id', Session::get('user_id'))->firstOrFail();
        
        // Pass the task to the edit form view
        return view('tasks.edit', compact('task'));
    }

    /**
     * Update an existing task in the database.
     * This handles the form submission from the edit page.
     * 
     * @param Request $request - Contains the updated task title
     * @param string $id - The ID of the task to update
     * @return \Illuminate\Http\RedirectResponse - Redirects back to tasks list with success message
     */
    public function update(Request $request, string $id)
    {
        // Find the task (ensuring it belongs to current user for security)
        $task = Task::where('id', $id)->where('user_id', Session::get('user_id'))->firstOrFail();

        // Validate the new title
        $request->validate([
            'title' => 'required|string|max:255'
        ]);

        // Update the task title with the new value from the form
        $task->title = $request->title;
        
        // Save the changes to the database
        $task->save();

        // Redirect to tasks list with success message
        return redirect('/tasks')->with('success', 'Task updated successfully');
    }

    /**
     * Remove a task from the database.
     * This deletes the specified task permanently.
     * 
     * @param string $id - The ID of the task to delete
     * @return \Illuminate\Http\RedirectResponse - Redirects back to tasks list with success message
     */
    public function destroy(string $id)
    {
        // Find the task (ensuring it belongs to current user for security)
        $task = Task::where('id', $id)->where('user_id', Session::get('user_id'))->firstOrFail();
        
        // Permanently delete the task from the database
        $task->delete();

        // Redirect to tasks list with success message
        return redirect('/tasks')->with('success', 'Task deleted successfully');
    }
}
