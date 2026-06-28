<?php

namespace App\Http\Controllers;

use App\Models\InformasiUmum;
use App\Models\Motif;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function home()
    {
        return view('public.home', [
            'motifCount' => Motif::count(),
            'sacredCount' => Motif::where('category', 'sakral')->count(),
            'verifiedCount' => Motif::where('verification_status', 'terverifikasi')->count(),
            'featuredMotifs' => Motif::latest()->take(4)->get(),
            'aboutContent' => InformasiUmum::where('key', 'tentang')->value('content'),
        ]);
    }

    public function catalog(Request $request)
    {
        $query = Motif::query()->latest();

        $query->when($request->filled('q'), function ($builder) use ($request): void {
            $builder->search($request->input('q'));
        });

        $query->when($request->filled('kategori'), function ($builder) use ($request): void {
            $builder->where('category', $request->input('kategori'));
        });

        $query->when($request->filled('makna'), function ($builder) use ($request): void {
            $builder->where('philosophical_meaning', 'like', '%'.$request->input('makna').'%');
        });

        return view('public.catalog', [
            'motifs' => $query->paginate(12)->withQueryString(),
            'filters' => $request->only(['q', 'kategori', 'makna']),
            'categories' => Motif::CATEGORIES,
            'totalMotifs' => Motif::count(),
        ]);
    }

    public function show(Motif $motif)
    {
        $motif->load('galleries');

        return view('public.show', [
            'motif' => $motif,
            'relatedMotifs' => Motif::whereKeyNot($motif->id)->latest()->take(3)->get(),
        ]);
    }

    public function about()
    {
        return view('public.about', [
            'aboutContent' => InformasiUmum::where('key', 'tentang')->value('content'),
            'pendingMotifs' => Motif::where('verification_status', 'perlu_pendalaman')->orderBy('name')->get(),
        ]);
    }

    public function contact()
    {
        return view('public.contact', [
            'contactContent' => InformasiUmum::where('key', 'kontak')->value('content'),
        ]);
    }
}