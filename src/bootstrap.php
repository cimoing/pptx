<?php

use Imoing\Pptx\Opc\OXml\CTDefault;
use Imoing\Pptx\Opc\OXml\CTOverride;
use Imoing\Pptx\Opc\OXml\CTRelationship;
use Imoing\Pptx\Opc\OXml\CTRelationships;
use Imoing\Pptx\Opc\OXml\CTTypes;
use Imoing\Pptx\OXml\Action\CTHyperlink;
use Imoing\Pptx\OXml\CoreProps\CTCoreProperties;
use Imoing\Pptx\OXml\Dml\Color\CTColor;
use Imoing\Pptx\OXml\Dml\Color\CTHslColor;
use Imoing\Pptx\OXml\Dml\Color\CTPercentage;
use Imoing\Pptx\OXml\Dml\Color\CTPresetColor;
use Imoing\Pptx\OXml\Dml\Color\CTSchemeColor;
use Imoing\Pptx\OXml\Dml\Color\CTScRgbColor;
use Imoing\Pptx\OXml\Dml\Color\CTSRgbColor;
use Imoing\Pptx\OXml\Dml\Color\CTSystemColor;
use Imoing\Pptx\OXml\Dml\Fill\CTBlip;
use Imoing\Pptx\OXml\Dml\Fill\CTBlipFillProperties;
use Imoing\Pptx\OXml\Dml\Fill\CTGradientFillProperties;
use Imoing\Pptx\OXml\Dml\Fill\CTGradientStop;
use Imoing\Pptx\OXml\Dml\Fill\CTGradientStopList;
use Imoing\Pptx\OXml\Dml\Fill\CTGroupFillProperties;
use Imoing\Pptx\OXml\Dml\Fill\CTLevelParaProperties;
use Imoing\Pptx\OXml\Dml\Fill\CTLinearShadeProperties;
use Imoing\Pptx\OXml\Dml\Fill\CTNoFillProperties;
use Imoing\Pptx\OXml\Dml\Fill\CTPatternFillProperties;
use Imoing\Pptx\OXml\Dml\Fill\CTRelativeRect;
use Imoing\Pptx\OXml\Dml\Fill\CTSolidColorFillProperties;
use Imoing\Pptx\OXml\Dml\Line\CTPresetLineDashProperties;
use Imoing\Pptx\OXml\Drawing\CTEffectList;
use Imoing\Pptx\OXml\Drawing\CTListStyle;
use Imoing\Pptx\OXml\Drawing\CTOuterShadow;
use Imoing\Pptx\OXml\Ns\NsMap;
use Imoing\Pptx\OXml\Presentation\CTPresentation;
use Imoing\Pptx\OXml\Presentation\CTSlideId;
use Imoing\Pptx\OXml\Presentation\CTSlideIdList;
use Imoing\Pptx\OXml\Presentation\CTSlideMasterIdList;
use Imoing\Pptx\OXml\Presentation\CTSlideMasterIdListEntry;
use Imoing\Pptx\OXml\Presentation\CTSlideSize;
use Imoing\Pptx\OXml\Shapes\AutoShape\CTAdjPoint2D;
use Imoing\Pptx\OXml\Shapes\AutoShape\CTCustomGeometry2D;
use Imoing\Pptx\OXml\Shapes\AutoShape\CTGeomGuide;
use Imoing\Pptx\OXml\Shapes\AutoShape\CTGeomGuideList;
use Imoing\Pptx\OXml\Shapes\AutoShape\CTNonVisualDrawingShapeProps;
use Imoing\Pptx\OXml\Shapes\AutoShape\CTPath2D;
use Imoing\Pptx\OXml\Shapes\AutoShape\CTPath2DClose;
use Imoing\Pptx\OXml\Shapes\AutoShape\CTPath2DCubicBezTo;
use Imoing\Pptx\OXml\Shapes\AutoShape\CTPath2DLineTo;
use Imoing\Pptx\OXml\Shapes\AutoShape\CTPath2DList;
use Imoing\Pptx\OXml\Shapes\AutoShape\CTPath2DMoveTo;
use Imoing\Pptx\OXml\Shapes\AutoShape\CTPresetGeometry2D;
use Imoing\Pptx\OXml\Shapes\AutoShape\CTShape;
use Imoing\Pptx\OXml\Shapes\AutoShape\CTShapeNonVisual;
use Imoing\Pptx\OXml\Shapes\Connector\CTConnection;
use Imoing\Pptx\OXml\Shapes\Connector\CTConnector;
use Imoing\Pptx\OXml\Shapes\Connector\CTConnectorNonVisual;
use Imoing\Pptx\OXml\Shapes\Connector\CTNonVisualConnectorProperties;
use Imoing\Pptx\OXml\Shapes\GroupShape\CTGroupShape;
use Imoing\Pptx\OXml\Shapes\GroupShape\CTGroupShapeNonVisual;
use Imoing\Pptx\OXml\Shapes\GroupShape\CTGroupShapeProperties;
use Imoing\Pptx\OXml\Shapes\Pictures\CTPicture;
use Imoing\Pptx\OXml\Shapes\Pictures\CTPictureNonVisual;
use Imoing\Pptx\OXml\Shapes\Shared\CTApplicationNonVisualDrawingProps;
use Imoing\Pptx\OXml\Shapes\Shared\CTCustomDash;
use Imoing\Pptx\OXml\Shapes\Shared\CTDashSegment;
use Imoing\Pptx\OXml\Shapes\Shared\CTLineProperties;
use Imoing\Pptx\OXml\Shapes\Shared\CTNonVisualDrawingProps;
use Imoing\Pptx\OXml\Shapes\Shared\CTPlaceholder;
use Imoing\Pptx\OXml\Shapes\Shared\CTPoint2D;
use Imoing\Pptx\OXml\Shapes\Shared\CTPositiveSize2D;
use Imoing\Pptx\OXml\Shapes\Shared\CTShapeProperties;
use Imoing\Pptx\OXml\Shapes\Shared\CTTransform2D;
use Imoing\Pptx\OXml\Slide\CTBackground;
use Imoing\Pptx\OXml\Slide\CTBackgroundProperties;
use Imoing\Pptx\OXml\Slide\CTBackgroundRef;
use Imoing\Pptx\OXml\Slide\CTColorMap;
use Imoing\Pptx\OXml\Slide\CTCommonSlideData;
use Imoing\Pptx\OXml\Slide\CTNotesMaster;
use Imoing\Pptx\OXml\Slide\CTNotesSlide;
use Imoing\Pptx\OXml\Slide\CTSlide;
use Imoing\Pptx\OXml\Slide\CTSlideLayout;
use Imoing\Pptx\OXml\Slide\CTSlideLayoutIdListEntry;
use Imoing\Pptx\OXml\Slide\CTSlideMaster;
use Imoing\Pptx\OXml\Slide\CTSlideTiming;
use Imoing\Pptx\OXml\Slide\CTTimeNodeList;
use Imoing\Pptx\OXml\Slide\CTTLMediaNodeVideo;
use Imoing\Pptx\OXml\Text\CTRegularTextRun;
use Imoing\Pptx\OXml\Text\CTTextBody;
use Imoing\Pptx\OXml\Text\CTTextBodyProperties;
use Imoing\Pptx\OXml\Text\CTTextCharacterProperties;
use Imoing\Pptx\OXml\Text\CTTextField;
use Imoing\Pptx\OXml\Text\CTTextFont;
use Imoing\Pptx\OXml\Text\CTTextLineBreak;
use Imoing\Pptx\OXml\Text\CTTextNormalAutofit;
use Imoing\Pptx\OXml\Text\CTTextParagraph;
use Imoing\Pptx\OXml\Text\CTTextParagraphProperties;
use Imoing\Pptx\OXml\Text\CTTextSpacing;
use Imoing\Pptx\OXml\Text\CTTextSpacingPercent;
use Imoing\Pptx\OXml\Text\CTTextSpacingPoint;
use Imoing\Pptx\OXml\Theme\CTColorMapOverrides;
use Imoing\Pptx\OXml\Theme\CTColorScheme;
use Imoing\Pptx\OXml\Theme\CTFillStyleList;
use Imoing\Pptx\OXml\Theme\CTFonts;
use Imoing\Pptx\OXml\Theme\CTFormatScheme;
use Imoing\Pptx\OXml\Theme\CTFontScheme;
use Imoing\Pptx\OXml\Theme\CTLineStyleList;
use Imoing\Pptx\OXml\Theme\CTOfficeStyleSheet;
use Imoing\Pptx\OXml\Theme\CTStyle;
use Imoing\Pptx\OXml\Theme\CTThemeElements;

NsMap::registerTagClass('ct:Default', CTDefault::class);
NsMap::registerTagClass('ct:Override', CTOverride::class);
NsMap::registerTagClass('ct:Types', CTTypes::class);

NsMap::registerTagClass('pr:Relationships', CTRelationships::class);
NsMap::registerTagClass('pr:Relationship', CTRelationship::class);

#action
NsMap::registerTagClass("a:hlinkClock", CTHyperlink::class);
NsMap::registerTagClass("a:hlinkHover", CTHyperlink::class);

#coreprops
NsMap::registerTagClass("cp:coreProperties", CTCoreProperties::class);

#dml.color
NsMap::registerTagClass("a:bgClr", CTColor::class);
NsMap::registerTagClass("a:fgClr", CTColor::class);
NsMap::registerTagClass("a:hslClr", CTHslColor::class);
NsMap::registerTagClass("a:lumMod", CTPercentage::class);
NsMap::registerTagClass("a:lumOff", CTPercentage::class);
NsMap::registerTagClass("a:alpha", CTPercentage::class);
NsMap::registerTagClass("a:prstClr", CTPresetColor::class);
NsMap::registerTagClass("a:schemeClr", CTSchemeColor::class);
NsMap::registerTagClass("a:scrgbClr", CTScRgbColor::class);
NsMap::registerTagClass("a:srgbClr", CTSRgbColor::class);
NsMap::registerTagClass("a:sysClr", CTSystemColor::class);

# theme.clr
NsMap::registerTagClass("a:dk1", CTColor::class);
NsMap::registerTagClass("a:lt1", CTColor::class);
NsMap::registerTagClass("a:dk2", CTColor::class);
NsMap::registerTagClass("a:lt2", CTColor::class);
NsMap::registerTagClass("a:accent1", CTColor::class);
NsMap::registerTagClass("a:accent2", CTColor::class);
NsMap::registerTagClass("a:accent3", CTColor::class);
NsMap::registerTagClass("a:accent4", CTColor::class);
NsMap::registerTagClass("a:accent5", CTColor::class);
NsMap::registerTagClass("a:accent6", CTColor::class);
NsMap::registerTagClass("a:hlink", CTColor::class);
NsMap::registerTagClass("a:folHlink", CTColor::class);


# dml.fill
NsMap::registerTagClass("a:blip", CTBlip::class);
NsMap::registerTagClass("a:blipFill", CTBlipFillProperties::class);
NsMap::registerTagClass("a:gradFill", CTGradientFillProperties::class);
NsMap::registerTagClass("a:grpFill", CTGroupFillProperties::class);
NsMap::registerTagClass("a:gs", CTGradientStop::class);
NsMap::registerTagClass("a:gsLst", CTGradientStopList::class);
NsMap::registerTagClass("a:lin", CTLinearShadeProperties::class);
NsMap::registerTagClass("a:noFill", CTNoFillProperties::class);
NsMap::registerTagClass("a:pattFill", CTPatternFillProperties::class);
NsMap::registerTagClass("a:solidFill", CTSolidColorFillProperties::class);
NsMap::registerTagClass("a:srcRect", CTRelativeRect::class);

# dml.line
NsMap::registerTagClass("a:prstDash", CTPresetLineDashProperties::class);
NsMap::registerTagClass("a:custDash", CTCustomDash::class);
NsMap::registerTagClass("a:ds", CTDashSegment::class);

#presentation
NsMap::registerTagClass("p:presentation", CTPresentation::class);
NsMap::registerTagClass("p:sldId", CTSlideId::class);
NsMap::registerTagClass("p:sldIdLst", CTSlideIdList::class);
NsMap::registerTagClass("p:sldMasterId", CTSlideMasterIdListEntry::class);
NsMap::registerTagClass("p:sldMasterIdLst", CTSlideMasterIdList::class);
NsMap::registerTagClass("p:sldSz", CTSlideSize::class);

#shapes.autoshape
NsMap::registerTagClass("a:avLst", CTGeomGuideList::class);
NsMap::registerTagClass("a:custGeom", CTCustomGeometry2D::class);
NsMap::registerTagClass("a:gd", CTGeomGuide::class);
NsMap::registerTagClass("a:gdLst", CTGeomGuideList::class);
NsMap::registerTagClass("a:close", CTPath2DClose::class);
NsMap::registerTagClass("a:lnTo", CTPath2DLineTo::class);
NsMap::registerTagClass("a:moveTo", CTPath2DMoveTo::class);
NsMap::registerTagClass('a:cubicBezTo', CTPath2DCubicBezTo::class);
NsMap::registerTagClass("a:path", CTPath2D::class);
NsMap::registerTagClass("a:pathLst", CTPath2DList::class);
NsMap::registerTagClass("a:prstGeom", CTPresetGeometry2D::class);
NsMap::registerTagClass("a:pt", CTAdjPoint2D::class);
NsMap::registerTagClass("p:cNvSpPr", CTNonVisualDrawingShapeProps::class);
NsMap::registerTagClass("p:nvSpPr", CTShapeNonVisual::class);
NsMap::registerTagClass("p:sp", CTShape::class);

NsMap::registerTagClass('p:graphicFrame', CTShape::class);

# shapes.connector
NsMap::registerTagClass("a:endCxn", CTConnection::class);
NsMap::registerTagClass("a:stCxn", CTConnection::class);
NsMap::registerTagClass("p:cNvCxnSpPr", CTNonVisualConnectorProperties::class);
NsMap::registerTagClass("p:cxnSp", CTConnector::class);
NsMap::registerTagClass("p:nvCxnSpPr", CTConnectorNonVisual::class);

# shapes.graphfrm

# shapes.groupshape
NsMap::registerTagClass("p:grpSp", CTGroupShape::class);
NsMap::registerTagClass("p:grpSpPr", CTGroupShapeProperties::class);
NsMap::registerTagClass("p:nvGrpSpPr", CTGroupShapeNonVisual::class);
NsMap::registerTagClass("p:spTree", CTGroupShape::class);

# shapes.picture
NsMap::registerTagClass("p:blipFill", CTBlipFillProperties::class);
NsMap::registerTagClass("p:nvPicPr", CTPictureNonVisual::class);
NsMap::registerTagClass("p:pic", CTPicture::class);

# shapes.shared
NsMap::registerTagClass("a:chExt", CTPositiveSize2D::class);
NsMap::registerTagClass("a:chOff", CTPoint2D::class);
NsMap::registerTagClass("a:ext",CTPositiveSize2D::class);
NsMap::registerTagClass("a:ln", CTLineProperties::class);
NsMap::registerTagClass("a:off", CTPoint2D::class);
NsMap::registerTagClass("a:xfrm",CTTransform2D::class);
NsMap::registerTagClass("c:spPr", CTShapeProperties::class);
NsMap::registerTagClass("p:cNvPr", CTNonVisualDrawingProps::class);
NsMap::registerTagClass("p:nvPr", CTApplicationNonVisualDrawingProps::class);
NsMap::registerTagClass("p:ph", CTPlaceholder::class);
NsMap::registerTagClass("p:spPr", CTShapeProperties::class);
NsMap::registerTagClass("p:xfrm", CTTransform2D::class);

# drawing
NsMap::registerTagClass("a:effectLst", CTEffectList::class);
NsMap::registerTagClass("a:outerShdw", CTOuterShadow::class);

# slide
NsMap::registerTagClass("p:bg", CTBackground::class);
NsMap::registerTagClass("p:bgPr", CTBackgroundProperties::class);
NsMap::registerTagClass("p:bgRef", CTBackgroundRef::class);
NsMap::registerTagClass("p:childTnLst", CTTimeNodeList::class);
NsMap::registerTagClass("p:cSld", CTCommonSlideData::class);
NsMap::registerTagClass("p:clrMap", CTColorMap::class);
NsMap::registerTagClass("a:overrideClrMapping", CTColorMap::class);
NsMap::registerTagClass("p:clrMapOvr", CTColorMapOverrides::class);
NsMap::registerTagClass("p:notes", CTNotesSlide::class);
NsMap::registerTagClass("p:notesMaster", CTNotesMaster::class);
NsMap::registerTagClass("p:sld", CTSlide::class);
NsMap::registerTagClass("p:sldLayout", CTSlideLayout::class);
NsMap::registerTagClass("p:sldLayoutId", CTSlideLayoutIdListEntry::class);
NsMap::registerTagClass("p:sldLayoutIdLst", \Imoing\Pptx\OXml\Slide\CTSlideLayoutIdList::class);
NsMap::registerTagClass("p:sldMaster", CTSlideMaster::class);
NsMap::registerTagClass("p:timing", CTSlideTiming::class);
NsMap::registerTagClass("p:video", CTTLMediaNodeVideo::class);

# table

# text
NsMap::registerTagClass("a:bodyPr", CTTextBodyProperties::class);
NsMap::registerTagClass("a:br", CTTextLineBreak::class);
NsMap::registerTagClass("a:defRPr", CTTextCharacterProperties::class);
NsMap::registerTagClass("a:endParaRPr", CTTextCharacterProperties::class);
NsMap::registerTagClass("a:fld", CTTextField::class);
NsMap::registerTagClass("a:latin", CTTextFont::class);
NsMap::registerTagClass("a:lnSpc", CTTextSpacing::class);
NsMap::registerTagClass("a:normAutofit", CTTextNormalAutofit::class);
NsMap::registerTagClass("a:r", CTRegularTextRun::class);
NsMap::registerTagClass("a:p", CTTextParagraph::class);
NsMap::registerTagClass("a:pPr", CTTextParagraphProperties::class);
NsMap::registerTagClass("c:rich", CTTextBody::class);
NsMap::registerTagClass("a:rPr", CTTextCharacterProperties::class);
NsMap::registerTagClass("a:spcAft", CTTextSpacing::class);
NsMap::registerTagClass("a:spcBef", CTTextSpacing::class);
NsMap::registerTagClass("a:spcPct", CTTextSpacingPercent::class);
NsMap::registerTagClass("a:spcPts", CTTextSpacingPoint::class);
NsMap::registerTagClass("a:txBody", CTTextBody::class);
NsMap::registerTagClass("c:txPr", CTTextBody::class);
NsMap::registerTagClass("p:txBody", CTTextBody::class);

# listStyle
NsMap::registerTagClass("a:lstStyle", CTListStyle::class);
NsMap::registerTagClass("a:lvl1pPr", CTLevelParaProperties::class);
NsMap::registerTagClass("a:lvl2pPr", CTLevelParaProperties::class);
NsMap::registerTagClass("a:lvl3pPr", CTLevelParaProperties::class);
NsMap::registerTagClass("a:lvl4pPr", CTLevelParaProperties::class);
NsMap::registerTagClass("a:lvl5pPr", CTLevelParaProperties::class);
NsMap::registerTagClass("a:lvl6pPr", CTLevelParaProperties::class);
NsMap::registerTagClass("a:lvl7pPr", CTLevelParaProperties::class);
NsMap::registerTagClass("a:lvl8pPr", CTLevelParaProperties::class);
NsMap::registerTagClass("a:lvl9pPr", CTLevelParaProperties::class);

# theme
NsMap::registerTagClass("a:theme", CTOfficeStyleSheet::class);
NsMap::registerTagClass("a:themeElements", CTThemeElements::class);
NsMap::registerTagClass("a:clrScheme", CTColorScheme::class);
NsMap::registerTagClass("a:fontScheme", CTFontScheme::class);
NsMap::registerTagClass("a:fmtScheme", CTFormatScheme::class);
NsMap::registerTagClass("a:lnStyleLst", CTLineStyleList::class);
NsMap::registerTagClass("a:fillStyleLst", CTFillStyleList::class);
NsMap::registerTagClass("a:bgFillStyleLst", CTFillStyleList::class);
NsMap::registerTagClass("a:majorFont", CTFonts::class);
NsMap::registerTagClass("a:minorFont", CTFonts::class);
NsMap::registerTagClass("p:style", CTStyle::class);
