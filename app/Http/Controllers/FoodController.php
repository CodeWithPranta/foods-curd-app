<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use NumberFormatter;

class FoodController extends Controller
{
    public function index(Request $request)
    {
        $latLng = $request->input('latitude') . ',' . $request->input('longitude');

        $foods = Food::nearby($latLng, 50)->get();

        return view('foods.index', [
            'foods' => $foods
        ]);
    }


    public function create()
    {
        return view('foods.create');
    }

    public function store(Request $request)
{
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|string', // Change to string validation
        'latitude' => 'required',
        'longitude' => 'required',
    ]);

    // // Convert price to user's currency
    // $userCurrency = getUserCurrencyCode();
    // $formatter = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
    // $formatter->setTextAttribute(NumberFormatter::CURRENCY_CODE, $userCurrency);

    // $priceString = $data['price'];
    // $price = $formatter->parseCurrency($priceString, $userCurrency);

    $food = new Food();
    $food->name = $data['name'];
    $food->description = $data['description'];
    $food->price = $data['price'];
    $food->latitude = $data['latitude'];
    $food->longitude = $data['longitude'];
    $food->save();

    return redirect()->route('foods.index')->with('success', 'Food item created successfully.');
}



    public function show($id)
    {
        $food = Food::findOrFail($id);
        return view('foods.show', compact('food'));
    }

    public function edit($id)
    {
        $food = Food::findOrFail($id);
        return view('foods.edit', compact('food'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        $food = Food::findOrFail($id);
        $food->name = $request->name;
        $food->description = $request->description;
        // Convert price to user's currency
        $userCurrency = getUserCurrencyCode();
        $price = convertCurrency($request->price, 'USD', $userCurrency);
        $food->price = $price;
        $food->latitude = $request->latitude;
        $food->longitude = $request->longitude;
        $food->save();

        return redirect()->route('foods.index')->with('success', 'Food updated successfully.');
    }

    public function destroy($id)
    {
        $food = Food::findOrFail($id);
        $food->delete();

        return redirect()->route('foods.index')->with('success', 'Food deleted successfully.');
    }

    public function search(Request $request)
    {
        $data = $request->validate([
            'address' => 'required',
            'radius' => 'required',
        ]);

        $location = $this->getLatLng($data['address']);
        $latLng = $location['lat'] . ',' . $location['lng'];

        $foods = Food::nearby($latLng, $data['radius'])->get();

        return view('foods.index', compact('foods'));
    }

}
