<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address ; 
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class AddressController extends Controller
{
    use AuthorizesRequests;
    
     /**
     * Display a listing of the user's addresses.
     */
    public function index()
    {
        $addresses = auth()->user()->addresses;
        return view('profile.addresses.index', compact('addresses'));
    }

    /**
     * Store a newly created address.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'country' => 'required|string|max:2',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'type' => 'required|in:shipping,billing,both',
            'is_default' => 'boolean',
        ]);

        $user = auth()->user();

        // If set as default, unset previous default of same type
        if ($request->boolean('is_default')) {
            if ($validated['type'] === 'both') {
                $user->addresses()->where('type', 'shipping')->update(['is_default' => false]);
                $user->addresses()->where('type', 'billing')->update(['is_default' => false]);
            } else {
                $user->addresses()->where('type', $validated['type'])->update(['is_default' => false]);
            }
        }

        $address = $user->addresses()->create([
            'full_name' => $validated['full_name'],
            'phone' => $validated['phone'] ?? null,
            'country' => $validated['country'],
            'address_line_1' => $validated['address_line_1'],
            'address_line_2' => $validated['address_line_2'] ?? null,
            'city' => $validated['city'],
            'state' => $validated['state'],
            'postal_code' => $validated['postal_code'],
            'type' => $validated['type'],
            'is_default' => $request->boolean('is_default'),
        ]);

        return redirect()->route('profile.addresses.index')->with('success', 'Address saved successfully.');
    }


        
    /**
     * Update the specified address.
     */
    public function update(Request $request, Address $address)
    {
        $this->authorize('update', $address);

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'country' => 'required|string|max:2',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'type' => 'required|in:shipping,billing,both',
            'is_default' => 'boolean',
        ]);

        $user = auth()->user();

        if ($request->boolean('is_default')) {
            if ($validated['type'] === 'both') {
                $user->addresses()->where('id', '!=', $address->id)->whereIn('type', ['shipping', 'billing'])->update(['is_default' => false]);
            } else {
                $user->addresses()->where('id', '!=', $address->id)->where('type', $validated['type'])->update(['is_default' => false]);
            }
        }

        $address->update($validated);

        return redirect()->route('profile.addresses.index')->with('success', 'Address updated successfully.');
    }

    /**
     * Remove the specified address.
     */
    public function destroy(Address $address)
    {
        $this->authorize('delete', $address);

        $address->delete();

        return redirect()->route('profile.addresses.index')->with('success', 'Address removed.');
    }
}
