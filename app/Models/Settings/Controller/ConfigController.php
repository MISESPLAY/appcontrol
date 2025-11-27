<?php
namespace App\Models\Settings\Controller;

use App\Http\Controllers\Controller;
use App\Models\Settings\Persistence\Eloquent\Setting;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    // 1. Mostrar lista y formulario
    public function index()
    {
        $settings = Setting::all();
        return view('settings', compact('settings'));
    }

    // 2. Guardar nueva configuración
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'font_size' => 'required|integer',
            'text_color' => 'required',
        ]);

        Setting::create($request->all());

        return redirect()->back()->with('success', 'Configuración guardada.');
    }

    // 3. Eliminar configuración
    public function destroy(Setting $setting)
    {
        $setting->delete();
        return redirect()->back()->with('success', 'Configuración eliminada.');
    }

    // Nota: Para mantenerlo "muy sencillo", omití la vista de 'edit' separada,
    // pero podrías agregarla siguiendo la misma lógica que 'store'.
}
