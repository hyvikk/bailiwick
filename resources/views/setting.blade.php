@extends('layouts.admin')

@section('content')
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="title">Set Currency </h4>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-content">
                            @if (count($errors) > 0)
                            <div class="alert alert-danger">
                            <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                            </ul>
                            </div>
                            @endif
                           {!! Form::open(['route' => 'setting.store','method'=>'post']) !!}
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Currency</label>
                                        <select class="form-control" name="currency" id="currency">
                                            <option value="">--select--</option>
                                            <option value="Lek" @if($amt_currency->currency == 'Lek') selected @endif>Lek(Lek)</option>
                                            <option value="؋" @if($amt_currency->currency == '؋') selected @endif>Afghani(؋)</option>
                                            <option value="$" @if($amt_currency->currency == '$') selected @endif>Dollar($)</option>
                                            <option value="ƒ" @if($amt_currency->currency == 'ƒ') selected @endif>Guilder(ƒ)</option>
                                            <option value="₼" @if($amt_currency->currency == '₼') selected @endif>Manat(₼)</option>      
                                            <option value="BZ$" @if($amt_currency->currency == 'BZ$') selected @endif>Belize Dollar(BZ$)</option>
                                            <option value="$b" @if($amt_currency->currency == '$b') selected @endif>Boliviano($b)</option>
                                            <option value="KM" @if($amt_currency->currency == 'KM') selected @endif>Convertible Marka(KM)</option>
                                            <option value="P" @if($amt_currency->currency == 'P') selected @endif>Pula(P)</option>
                                            <option value="лв" @if($amt_currency->currency == 'лв') selected @endif>Lev(лв)</option>
                                            <option value="R$" @if($amt_currency->currency == 'R$') selected @endif>Real(R$)</option>
                                            <option value="៛" @if($amt_currency->currency == '៛') selected @endif>Riel(៛)</option>
                                            <option value="¥" @if($amt_currency->currency == '¥') selected @endif>Yuan Renminbi(¥)</option>
                                            <option value="₡" @if($amt_currency->currency == '₡') selected @endif>Colon(₡)</option>
                                            <option value="kn" @if($amt_currency->currency == 'kn') selected @endif>Kuna(kn)</option>
                                            <option value="₱" @if($amt_currency->currency == '₱') selected @endif>Peso(₱)</option>
                                            <option value="Kč" @if($amt_currency->currency == 'Kč') selected @endif>Koruna(Kč)</option>
                                            <option value="kr" @if($amt_currency->currency == 'kr') selected @endif>Krone(kr)</option>
                                            <option value="£" @if($amt_currency->currency == '£') selected @endif>Pound(£)</option>
                                            <option value="€" @if($amt_currency->currency == '€') selected @endif>Euro(€)</option>
                                            <option value="₾" @if($amt_currency->currency == '₾') selected @endif>Lari(₾)</option>
                                            <option value="¢" @if($amt_currency->currency == '¢') selected @endif>Cedis(¢)</option>
                                            <option value="Q" @if($amt_currency->currency == 'Q') selected @endif>Quetzal(Q)</option>
                                            <option value="L" @if($amt_currency->currency == 'L') selected @endif>Lempira(L)</option>
                                            <option value="Ft" @if($amt_currency->currency == 'Ft') selected @endif>Forint(Ft)</option>
                                            <option value="Rp" @if($amt_currency->currency == 'Rp') selected @endif>Rupiah(Rp)</option>
                                            <option value="﷼" @if($amt_currency->currency == '﷼') selected @endif>Rial(﷼)</option>
                                            <option value="₪" @if($amt_currency->currency == '₪') selected @endif>Shekel(₪)</option>
                                            <option value="J$" @if($amt_currency->currency == 'J$') selected @endif>Jamaica Dollar(J$)</option>
                                            <option value="₩"@if($amt_currency->currency == '₩') selected @endif>Won(₩)</option>
                                            <option value="₭" @if($amt_currency->currency == '₭') selected @endif>Kip(₭)</option>
                                            <option value="Ls" @if($amt_currency->currency == 'Ls') selected @endif>Lat(Ls)</option>
                                            <option value="Lt" @if($amt_currency->currency == 'Lt') selected @endif>Litas(Lt)</option>
                                            <option value="ден" @if($amt_currency->currency == 'ден') selected @endif>Denar(ден)</option>
                                            <option value="RM" @if($amt_currency->currency == 'RM') selected @endif>Ringgit(RM)</option>
                                            <option value="₨" @if($amt_currency->currency == '₨') selected @endif>Rupee(₨)</option>
                                            <option value="₮" @if($amt_currency->currency == '₮') selected @endif>Tughrik(₮)</option>
                                            <option value="MT" @if($amt_currency->currency == 'MT') selected @endif>Metical(MT)</option>
                                            <option value="C$" @if($amt_currency->currency == 'C$') selected @endif>Cordoba(C$)</option>
                                            <option value="₦" @if($amt_currency->currency == '₦') selected @endif>Naira(₦)</option>
                                            <option value="B/." @if($amt_currency->currency == 'B/.') selected @endif>Balboa(B/.)</option>
                                            <option value="Gs" @if($amt_currency->currency == 'Gs') selected @endif>Guarani(Gs)</option>
                                            <option value="S/."@if($amt_currency->currency == 'S/.') selected @endif>Nuevo Sol(S/.)</option>
                                            <option value="zł" @if($amt_currency->currency == 'zł') selected @endif>Zloty(zł)</option>
                                            <option value="lei" @if($amt_currency->currency == 'lei') selected @endif>New Leu(lei)</option>
                                            <option value="₽" @if($amt_currency->currency == '₽') selected @endif>Ruble(₽)</option>
                                            <option value="Дин." @if($amt_currency->currency == 'Дин.') selected @endif>Dinar(Дин.)</option>
                                            <option value="S" @if ($amt_currency->currency == 'S') selected @endif>Shilling(S)</option>
                                            <option value="R" @if($amt_currency->currency == 'R') selected @endif>Rand(R)</option>
                                            <option value="CHF" @if($amt_currency->currency == 'CHF') selected @endif>Franc(CHF)</option>
                                            <option value="NT$" @if($amt_currency->currency == 'NT$') selected @endif>New Dollar(NT$)</option>
                                            <option value="฿" @if($amt_currency->currency == '฿') selected @endif>Baht(฿)</option>
                                            <option value="TT$" @if($amt_currency->currency == 'TT$') selected @endif>Trinidad and Tobago Dollar(TT$)</option>
                                            <option value="₺" @if($amt_currency->currency == '₺') selected @endif>Lira(₺)</option>
                                            <option value="₴" @if($amt_currency->currency == '₴') selected @endif>Hryvna(₴)</option>
                                            <option value="Bs" @if($amt_currency->currency == 'Bs') selected @endif>Bolivar Fuerte(Bs)</option>
                                            <option value="₫" @if($amt_currency->currency == '₫') selected @endif>Dong(₫)</option>
                                            <option value="Z$" @if($amt_currency->currency == 'Z$') selected @endif>Zimbabwe Dollar(Z$)</option>
                                       </select>    
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                       <button type="submit" class="btn btn-fill btn-info">Submit</button>
                                    </div>
                                </div>
                            </div>
                       {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
@endsection
